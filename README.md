# LDB

This repository contains the software code for the current research information
system of [Leibniz-Institute of Freshwater Ecology and Inland
Fisheries](http://www.igb-berlin.de/) (IGB) in Forschungsverbund Berlin e. V.
Its development was funded by the IGB in 2017. This web application allows to
manage in-house publication records as well as other data about research
activities (such as lectures, committee actitivities, keynotes and
presentations, media relations and supervision) and to produce reports in
various ways. Please contact [Lydia  Koglin](mailto:koglin@igb-berlin.de) if you
like to know more about the implementation at IGB. The application was
implemented by [Wendig OÜ](https://wendig.io).

## Development setup

* install VirtualBox (https://www.virtualbox.org/)
* install vagrant (https://www.vagrantup.com/)

install the guest additions plugin:

    vagrant plugin install vagrant-vbguest

build the vm

    vagrant up

when its done, run

    vagrant reload

to make use of the newly installed VirtualBox guest additions.

Now login to the vm prepare the app:

    vagrant ssh
    cd /vagrant

    # install php dependencies
    composer install

    # now, either provide an existing mysql dump
    cp /path/to/dump.sql .

    # or create the db from the structure dump (no data)
    cat structure.sql | mysql -h localhost -u root -proot ldb

    # run the setup including migrations
    ./setup.sh
    
and start the app

    ./dev.sh

The app should be running at http://localhost:3000

## Testing

With the above steps completed (development setup), you can also run

    ./test.sh

to start the test web server and then, in another terminal

    vagrant ssh

    # then from within the vm, run
    cd /vagrant
    vendor/codeception/codeception/codecept run acceptance 

to run the full acceptance test suite (takes several minutes to complete)

## Production setup

First, install ubuntu 16.04. Then, checkout the repo to a suitable location:

    git clone https://github.com/wendig-ou/ldb.git /var/www/ldb

And make that your working directory for the next steps. Then, have a look at
`provision.sh` to understand what requirements should be installed via apt-get.
You can also just run the file if you don't mind that some dev requirements are
also being installed:

    sh provision.sh base
    sh provision.sh apache

Then, run composer to install php dependencies

    composer install

Make sure there is a suitable `.env` file that reflects your installation. The
default configuration just provides database connectivity.

Now, put a dump file to `/var/www/ldb/dump.sql` and run the setup script:

    sh setup.sh

After configuring an apache vhost to serve `/var/www/ldb/public` as
`DocumentRoot`, your installation should be working. Make sure that
`AllowOverride all` is set for all subdirectories.

Also, make sure that apache can write to /var/www/ldb, e.g with

    chown -R www-data. /var/www/ldb

## Specific topics

**How can I add a new report query?**

Just put the query in a text file within the `./reports` directory and give it a
`.sql` file extension. The file name is shown in the web interface as the report
name.

**How to add or change publication types**

* add a record in the `super_types` table if a new one is required
  * make sure there is a respective form for the super_type (matching column
    `code`) in `application/views/publications/sub_forms`
* add a record in the `ToW` table setting the `active` flag. The referenced
  super_type sets the web form.
* if the chosen super_type is 'publication':
  * check `application/views/publications/sub_forms/pub.php`
  * check `public/widgets/if_type.tag`
* check controller in `application/controllers/Publications.php` to see if
  validation/handling has to be modified

## Production settings

Make sure, `memory_limit` is sufficiently high in `php.ini` to run all report
queries. 2G is a good value.
