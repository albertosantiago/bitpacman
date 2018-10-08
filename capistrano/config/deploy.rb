lock '3.5.0'

set :ssh_options, { user: 'deploy' }
set :tmp_dir, '/home/deploy/tmp'
set :application, 'bitpacman'
set :repo_url, 'git@gitlab.com:chucho/bitpacman.git'
set :deploy_to, '/var/www/bitpacman/deploy'

namespace :app do
    desc "Stop App"
    task :stop do
        on roles(:app) do
            within release_path do
                f = "#{release_path}/artisan"
                if test("[ -f #{f} ]")
                    execute :php, "artisan down"
                else
                    info "There are no previous version in host!"
                end
            end
        end
    end
    desc "Start App"
    task :start do
        on roles(:app) do
            within release_path do
                execute :php, "artisan up"
            end
        end
    end
end

namespace :setup do
    desc "Install composer and bower dependencies, make pending migrations in db and change file permissions"
    task :init do
        on roles(:app) do
            within release_path do
                execute :composer, "install --no-dev"
                execute :composer, "dumpautoload"
                execute :bower, "install"
                execute :php, "artisan migrate --force"
                execute "sudo mkdir #{fetch(:release_path)}/storage/framework/sessions"
                execute "sudo chmod 775 #{fetch(:release_path)} -R"
            end
        end
    end
    desc "Setup File Permissions"
    task :permissions do
        on roles(:app) do
            within deploy_to do
                execute "sudo chmod 775 #{fetch(:deploy_to)} -R"
            end
        end
    end
end

namespace :environment do
    desc "Set environment variables"
    task :set_variables do
        on roles(:app) do
            within release_path do
                puts ("--> Create environment configuration file")
                execute "cat /dev/null > #{fetch(:release_path)}/.env"
                execute "echo APP_ENV=#{fetch(:app_env)} >> #{fetch(:release_path)}/.env"
                execute "echo APP_DEBUG=#{fetch(:app_debug)} >> #{fetch(:release_path)}/.env"
                execute "echo APP_KEY=#{fetch(:app_key)} >> #{fetch(:release_path)}/.env"
                execute "echo COOKIE_DOMAIN=#{fetch(:cookie_domain)} >> #{fetch(:release_path)}/.env"
                execute "echo DB_HOST=#{fetch(:db_host)} >> #{fetch(:release_path)}/.env"
                execute "echo DB_DATABASE=#{fetch(:db_database)} >> #{fetch(:release_path)}/.env"
                execute "echo DB_USER=#{fetch(:db_user)} >> #{fetch(:release_path)}/.env"
                execute "echo DB_PASSWORD=#{fetch(:db_password)} >> #{fetch(:release_path)}/.env"
            end
        end
    end
end

namespace :deploy do
    before :starting, "app:stop"
    after :finished,  "setup" do
        invoke("environment:set_variables")
        invoke("setup:init")
        invoke("app:start")
    end
    before :cleanup, "setup:permissions"
end
