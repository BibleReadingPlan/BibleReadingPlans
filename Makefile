SVN = ${HOME}/src/svn/bible-reading-plans

zip:
	zip -r bible-reading-plans.zip bible-reading-plans-{class,hooks}.inc.php bible-reading-plans.php css/ images/ includes/ js/ languages/ LICENSE README.md readme.txt screen-shots

svn:
	cp -r *.php css images includes js languages LICENSE README.md readme.txt ${SVN}/trunk

test:
	set -a && . $(CURDIR)/.env && set +a && phpunit
