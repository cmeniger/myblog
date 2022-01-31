# Message format
#
# command: ##@group&option Message
# - ##   : show command in help
# - @xxx : group name
# - &xxx : options name
HELP = \
    %help; \
    while(<>) { push @{$$help{$$2}}, [$$1, $$3, $$4] if /^([a-zA-Z\-]+)\s*:.*\#\#(?:@([a-zA-Z\-]+))(?:&([a-zA-Z\-\|]+))?\s(.*)$$/ }; \
    print "${WHITE}usage:${RESET} ${WHITE}${BOLD}make${RESET} ${YELLOW}<command>${RESET} ${CYAN}<options>${RESET}\n\n"; \
    for (sort keys %help) { \
		print "${WHITE}$$_:${RESET}\n"; \
		for (@{$$help{$$_}}) { \
			$$sep1 = " " x (25 - length $$_->[0]); \
			$$sep2 = " " x (10 - length $$_->[1]); \
			print "  ${YELLOW}$$_->[0]${RESET}$$sep1${CYAN+}$$_->[1]${RESET}$$sep2${GREEN}$$_->[2]${RESET}\n"; \
		}; \
		print "\n"; \
	}

help: ##@help Show this help
	@perl -e '$(HELP)' $(MAKEFILE_LIST)
