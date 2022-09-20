php_lint:
	@echo "Starting phpstan..."
	./vendor/bin/phpstan analyse --level=9 app/Models app/Http/Controllers app/Services routes tests

