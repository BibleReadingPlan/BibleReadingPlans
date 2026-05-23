SVN = ${HOME}/src/svn/bible-reading-plans

zip:
	zip -r bible-reading-plans.zip bible-reading-plans-{class,hooks}.inc.php bible-reading-plans.php css/ images/ includes/ js/ languages/ LICENSE README.md readme.txt screen-shots

svn:
	cp -r *.php css images includes js languages LICENSE README.md readme.txt ${SVN}/trunk

test:
	git checkout HEAD -- includes/plans/
	script -q -e -c 'npx wp-env run tests-cli --env-cwd wp-content/plugins/BibleReadingPlans -- phpunit' /dev/null

test-local:
	set -a && . $(CURDIR)/.env && set +a && phpunit

test-show-dep:
	set -a && . $(CURDIR)/.env && set +a && vendor/bin/phpunit --display-deprecations

composer:
	composer update --prefer-dist --dev --optimize-autoloader

wp-env:
	npm install --save-dev @wordpress/env

wp-env-start:
	npx wp-env start

wp-env-stop:
	npx wp-env stop
