sf-console: ##@symfony&cmd Run console command
	$(call m-back, bin/console ${cmd})

sf-composer: ##@symfony&cmd Run composer command
	$(call m-back, composer ${cmd})

sf-cache: ##@symfony Clean cache
	$(MAKE) sf-console cmd="cache:clear -v"

sf-cache-rm: ##@symfony Remove cache
	$(call m-back, rm -rf var/cache)

sf-cache-dev: ##@symfony Clean cache for env dev
	$(MAKE) sf-console cmd="cache:clear --env=dev -v"

sf-cp-install: ##@symfony Run composer install
	$(MAKE) sf-composer cmd="install"
