<pagination>

  <form if={url} class="form-inline">
    <ul class="pager" if={url}>
      <virtual if={total() > perPage()}>
        <li if={page() > 1}>
          <a href="#" onclick={previousPage}>{t('igb_previous')}</a>
        </li>
        <li>
          <select class="form-control" onchange={goto} ref="pageSelect">
            <option
              each={p in pages()}
              selected={p == page()}
            >{p}</option>
          </select>
          / {Math.floor(total() / perPage())} {t('igb_pages')}
        </li>
        <li if={page() < total() / perPage() - 1}>
          <a href="#" onclick={nextPage}>{t('igb_next')}</a>
        </li>
        <li if={opts.showAll}>
          <a href="#" onclick={showAll}>{t('igb_show_all')}</a>
        </li>
      </virtual>
      <li class="amount">
        <strong>{total()}</strong>
        {t('igb_results')}
      </li>
    </ul>
  </form>

  <script type="text/javascript">
    var tag = this;

    tag.on('mount', function() {
      tag.url = document.createElement('a');
      tag.url.href = document.location.href;
      tag.update();
    });

    tag.goto = function(event, nextPage) {
      nextPage = nextPage || $(tag.refs.pageSelect).val();
      tag.replaceParam('page', nextPage);
    }

    tag.previousPage = function(event) {
      event.preventDefault();
      tag.goto(null, tag.page() - 1);
    }

    tag.nextPage = function(event) {
      event.preventDefault();
      tag.goto(null, tag.page() + 1);
    }

    tag.showAll = function(event) {
      event.preventDefault();
      tag.replaceParam('per-page', tag.total())
    }

    tag.page = function() {
      return parseInt(tag.param('page') || 1);
    }

    tag.perPage = function() {
      return parseInt(tag.param('per-page') || 20);
    }

    tag.pages = function() {
      var results = [];
      for (i = 1; i * tag.perPage() < tag.total(); i += 1) {
        results.push(i);
      }
      return results;
    }

    tag.total = function() {
      return parseInt(tag.opts.total);
    }

    tag.param = function(name) {
      var regex = new RegExp('[\?&]' + name + '=([^&]*)');
      if (m = tag.url.search.match(regex)) {
        return m[1];
      }
    }

    tag.replaceParam = function(name, value) {
      if (tag.param(name)) {
        var regex = new RegExp('([\?&])' + name + '=[^&]*');
        tag.url.search = tag.url.search.replace(regex, '$1' + name + '=' + value);
      } else {
        tag.url.search += '&' + name + '=' + value;
      }

      document.location.href = tag.url.href;
    }

    tag.t = function(key, cap = false) {
      var result = translations[key];
      return (cap ? result.charAt(0).toUpperCase() + result.slice(1) : result);
    }

  </script>

</pagination>