BLACK   := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 0 || echo "")
RED     := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 1 || echo "")
GREEN   := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 2 || echo "")
YELLOW  := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 3 || echo "")
BLUE    := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 4 || echo "")
MAGENTA := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 5 || echo "")
CYAN    := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 6 || echo "")
WHITE   := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 7 || echo "")
RESET   := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm sgr0 || echo "")
BOLD    := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm bold || echo "")

define text-title
	@echo "${GREEN}===================================${RESET}"
	@echo "${GREEN} > ${BOLD}$(1)${RESET}"
	@echo "${GREEN}===================================${RESET}"
endef

define text-subtitle
	@echo "${BLUE}--------------------------${RESET}"
	@echo "${BLUE} > ${BOLD}$(1)${RESET}"
	@echo "${BLUE}--------------------------${RESET}"
endef

define text-comment
	@echo "${CYAN}# $(1)${RESET}"
endef

define text-color
	@echo "${$(1)}$(2)${RESET}"
endef

define text-green
	${call text-color,GREEN,$(1)}
endef

define text-blue
	${call text-color,BLUE,$(1)}
endef

define text-white
	${call text-color,WHITE,${BOLD}$(1)}
endef

define text-yellow
	${call text-color,YELLOW,$(1)}
endef

define text-red
	${call text-color,RED,$(1)}
endef

define text-black
	${call text-color,BLACK,$(1)}
endef

define text-magenta
	${call text-color,MAGENTA,$(1)}
endef

define text-cyan
	${call text-color,CYAN,$(1)}
endef

define text-grey
	${call text-color,WHITE,$(1)}
endef

define text-error
	${call text-color,RED,❌ $(1)}
endef

define text-warning
	${call text-color,YELLOW,⚠️  $(1)}
endef

define text-success
	${call text-color,GREEN,✅ $(1)}
endef

define text-list
	${call text-color,WHITE,$(1) $(2)}
endef

define text-list-chevron
	${call text-list,>,$(1)}
endef

define text-list-bullet
	${call text-list,•,$(1)}
endef

define text-check-true
	${call text-list,[x],$(1)}
endef

define text-check-false
	${call text-list,[ ],$(1)}
endef
