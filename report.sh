#!/usr/bin/env bash

phpmd . xml phpmd-ruleset.xml --reportfile report/phpmd.xml --exclude vendor

phpcs --colors --report="xml" --report-file="report/phpcs.xml" \
    --encoding=UTF8 --standard=PSR1,PSR2 --tab-width=4 --ignore=vendor .

pdepend --dependency-xml=report/dependencies.xml \
    --jdepend-chart=report/jdepend-chart.svg \
    --jdepend-xml=report/jdepend-xml.xml \
    --overview-pyramid=report/overview-pyramid.svg \
    --summary-xml=report/sumary-xml.xml \
    --ignore=vendor \
    .