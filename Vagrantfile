Vagrant.configure("2") do |config|
  config.vm.box = "bento/ubuntu-16.04"

  config.vm.define "dev", :primary => true do |c|
    if RUBY_PLATFORM.match(/darwin/)
      config.vm.synced_folder ".", "/vagrant", type: "nfs"
      # config.vm.network "private_network", type: "dhcp"
    else
      config.vm.synced_folder ".", "/vagrant", type: "virtualbox"
    end
    c.vm.network :forwarded_port, host: 3000, guest: 3000
    c.vm.network :forwarded_port, host: 3999, guest: 3999
    c.vm.provider "virtualbox" do |vbox|
      vbox.name = "ldb-frontend-dev"
      vbox.customize ["modifyvm", :id, "--memory", "2048"]
      vbox.customize ["modifyvm", :id, "--cpus", "2"]
    end

    c.vm.provision :shell, path: 'provision.sh', args: 'base'
  end

end
