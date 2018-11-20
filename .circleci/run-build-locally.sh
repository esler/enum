#!/usr/bin/env bash
curl --user ${CIRCLE_TOKEN}: \
    --request POST \
    --form revision=9434d298f18b266a169d39542986576f195a00de\
    --form config=@config.yml \
    --form notify=false \
        https://circleci.com/api/v1.1/project/github/intraworlds/enum/tree/master
