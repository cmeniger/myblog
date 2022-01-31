define test-run
	$(call m-back, bin/phpunit $(1))
endef

test-single: ##@test&test|e Run single test, use e=1 for show errors
ifdef e
	$(call test-run, $(test))
else
	$(call test-run, --testdox $(test))
endif

test-unit: ##@test Run all unit tests
	$(call test-run, --testdox)
