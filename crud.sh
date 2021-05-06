#!/bin/bash
###################### VARIABLES #############################
# Docker
CONTAINER="api.guideline.xcs"
WORK_DIR="/app"
DOCKER_EXEC="docker exec -it $CONTAINER"  # Leave empty if not working inside docker (linux)

# Execution Location Prompt
echo "================================================================"
echo "Current Location:" && pwd
echo "----------------------------------------------------------------"
while true; do
    read -p "Are you executing inside the 'crud' folder? [y/n]:" yn
    case $yn in
        [Yy]* ) break;;
        [Nn]* ) echo "Please CD inside the 'crud' folder first!'"; exit;;
        * ) echo "Please answer yes or no [y/n].";;
    esac
done



###################### USER INPUT ############################
# MODEL NAME
echo "======================================================="
echo "Input API resource model name, singular and plural:"
read -e -p "Singular:" BASE_MODEL_SINGULAR
BASE_lower_singular=$(perl -ne 'print lc' <<<"$BASE_MODEL_SINGULAR")
BASE_Upper_singular=$(perl -ne 'print ucfirst' <<<"$BASE_lower_singular")
read -e -p "Plural:" BASE_MODEL_PLURAL
BASE_lower_plural=$(perl -ne 'print lc' <<<"$BASE_MODEL_PLURAL")
BASE_Upper_plural=$(perl -ne 'print ucfirst' <<<"$BASE_lower_plural")

# NESTING
echo "======================================================="
while true; do
    read -p "Nest model? [y/n]:" yn
    case $yn in
        [Yy]* ) echo "Input nesting parent model name:" \
            && read -e -p "Singular:" NEST_MODEL_SINGULAR \
            && NEST_lower_singular=$(perl -ne 'print lc' <<<"$NEST_MODEL_SINGULAR") \
            && NEST_Upper_singular=$(perl -ne 'print ucfirst' <<<"$NEST_lower_singular") \
            && read -e -p "Plural:" NEST_MODEL_PLURAL \
            && NEST_lower_plural=$(perl -ne 'print lc' <<<"$NEST_MODEL_PLURAL") \
            && NEST_Upper_plural=$(perl -ne 'print ucfirst' <<<"$NEST_lower_plural") \
            && ROUTE="${NEST_lower_plural}.${BASE_lower_plural}" \
            ; break;;
        [Nn]* ) ROUTE="${BASE_lower_plural}" \
            ; break;;
        * ) echo "Please answer yes or no [y/n].";;
    esac
done



###################### ARTISAN MAKE ##########################
echo "======================================================="
# Make Model
echo "Creating '${BASE_Upper_singular}' model with 'create_${BASE_lower_plural}_table' migration ..."
$DOCKER_EXEC php artisan make:model $BASE_Upper_singular -m
MIGRATION_PATH=$($DOCKER_EXEC find ${WORK_DIR}/database/migrations -type f -name "*create_${BASE_lower_plural}_table*")
REMOVE_EXT="${MIGRATION_PATH%%.*}"
MIGRATION_NAME="${REMOVE_EXT##*/}"

# Make Controller (API)
echo "Creating '${BASE_Upper_singular}Controller' with API methods ..."
$DOCKER_EXEC php artisan make:controller ${BASE_Upper_singular}Controller --api --model=$BASE_Upper_singular

# Make Resource
echo "Creating '${BASE_Upper_singular}Resource' ..."
$DOCKER_EXEC php artisan make:resource ${BASE_Upper_singular}Resource

# Make Policy
echo "Creating '${BASE_Upper_singular}Policy' ..."
$DOCKER_EXEC php artisan make:policy ${BASE_Upper_singular}Policy --model=$BASE_Upper_singular

# Make Request
echo "Creating '${BASE_Upper_singular}Request' ..."
$DOCKER_EXEC php artisan make:request ${BASE_Upper_singular}Request



###################### COPY & EDIT ###########################
echo "======================================================="
# Copy & Edit Placeholder Model
echo "Copy & Edit Placeholder Model"
if [ $NEST_MODEL_SINGULAR ] ; then
    docker cp nest/Model.php $CONTAINER:${WORK_DIR}/app/Models/${BASE_Upper_singular}.php
else
    docker cp base/Model.php $CONTAINER:${WORK_DIR}/app/Models/${BASE_Upper_singular}.php
fi
$DOCKER_EXEC sed -i "s+BASE_Upper_singular+${BASE_Upper_singular}+g" ${WORK_DIR}/app/Models/${BASE_Upper_singular}.php
$DOCKER_EXEC sed -i "s+BASE_lower_singular+${BASE_lower_singular}+g" ${WORK_DIR}/app/Models/${BASE_Upper_singular}.php
$DOCKER_EXEC sed -i "s+NEST_Upper_singular+${NEST_Upper_singular}+g" ${WORK_DIR}/app/Models/${BASE_Upper_singular}.php
$DOCKER_EXEC sed -i "s+NEST_lower_singular+${NEST_lower_singular}+g" ${WORK_DIR}/app/Models/${BASE_Upper_singular}.php

# Copy & Edit Placeholder Migration
echo "Copy & Edit Placeholder Migration"
docker cp base/Migration.php $CONTAINER:${WORK_DIR}/database/migrations/${MIGRATION_NAME}.php
$DOCKER_EXEC sed -i "s+BASE_lower_plural+${BASE_lower_plural}+g" ${WORK_DIR}/database/migrations/${MIGRATION_NAME}.php
$DOCKER_EXEC sed -i "s+BASE_Upper_plural+${BASE_Upper_plural}+g" ${WORK_DIR}/database/migrations/${MIGRATION_NAME}.php
if [ $NEST_MODEL_SINGULAR ] ; then
    $DOCKER_EXEC sed -i "s+//RELATION_PLACEHOLDER+\$table->unsignedBigInteger('NEST_id')->references('id')->on('NEST_table')->onDelete('cascade');+" ${WORK_DIR}/database/migrations/${MIGRATION_NAME}.php
    $DOCKER_EXEC sed -i "s+NEST_id+${NEST_lower_singular}_id+g" ${WORK_DIR}/database/migrations/${MIGRATION_NAME}.php
    $DOCKER_EXEC sed -i "s+NEST_table+${NEST_lower_plural}+g" ${WORK_DIR}/database/migrations/${MIGRATION_NAME}.php
fi


# Copy & Edit Placeholder Controller
echo "Copy & Edit Placeholder Controller"
if [ $NEST_MODEL_SINGULAR ] ; then
    docker cp nest/Controller.php $CONTAINER:${WORK_DIR}/app/Http/Controllers/${BASE_Upper_singular}Controller.php
    $DOCKER_EXEC sed -i "s+NEST_lower_singular+${NEST_lower_singular}+g" ${WORK_DIR}/app/Http/Controllers/${BASE_Upper_singular}Controller.php
    $DOCKER_EXEC sed -i "s+NEST_Upper_singular+${NEST_Upper_singular}+g" ${WORK_DIR}/app/Http/Controllers/${BASE_Upper_singular}Controller.php
else
    docker cp base/Controller.php $CONTAINER:${WORK_DIR}/app/Http/Controllers/${BASE_Upper_singular}Controller.php
fi
$DOCKER_EXEC sed -i "s+BASE_lower_singular+${BASE_lower_singular}+g" ${WORK_DIR}/app/Http/Controllers/${BASE_Upper_singular}Controller.php
$DOCKER_EXEC sed -i "s+BASE_Upper_singular+${BASE_Upper_singular}+g" ${WORK_DIR}/app/Http/Controllers/${BASE_Upper_singular}Controller.php
$DOCKER_EXEC sed -i "s+BASE_lower_plural+${BASE_lower_plural}+g" ${WORK_DIR}/app/Http/Controllers/${BASE_Upper_singular}Controller.php


# Copy & Edit Placeholder Policy
echo "Copy & Edit Placeholder Policy"
if [ $NEST_MODEL_SINGULAR ] ; then
    docker cp nest/Policy.php $CONTAINER:${WORK_DIR}/app/Policies/${BASE_Upper_singular}Policy.php
else
    docker cp base/Policy.php $CONTAINER:${WORK_DIR}/app/Policies/${BASE_Upper_singular}Policy.php
fi
$DOCKER_EXEC sed -i "s+BASE_Upper_singular+${BASE_Upper_singular}+g" ${WORK_DIR}/app/Policies/${BASE_Upper_singular}Policy.php
$DOCKER_EXEC sed -i "s+BASE_lower_singular+${BASE_lower_singular}+g" ${WORK_DIR}/app/Policies/${BASE_Upper_singular}Policy.php
$DOCKER_EXEC sed -i "s+BASE_lower_plural+${BASE_lower_plural}+g" ${WORK_DIR}/app/Policies/${BASE_Upper_singular}Policy.php
$DOCKER_EXEC sed -i "s+NEST_Upper_singular+${NEST_Upper_singular}+g" ${WORK_DIR}/app/Policies/${BASE_Upper_singular}Policy.php
$DOCKER_EXEC sed -i "s+NEST_lower_singular+${NEST_lower_singular}+g" ${WORK_DIR}/app/Policies/${BASE_Upper_singular}Policy.php
$DOCKER_EXEC sed -i "s+NEST_lower_plural+${NEST_lower_plural}+g" ${WORK_DIR}/app/Policies/${BASE_Upper_singular}Policy.php

# Copy & Edit Placeholder Request
echo "Copy & Edit Placeholder Request"
docker cp base/Request.php $CONTAINER:${WORK_DIR}/app/Http/Requests/${BASE_Upper_singular}Request.php
$DOCKER_EXEC sed -i "s+BASE_Upper_singular+${BASE_Upper_singular}+g" ${WORK_DIR}/app/Http/Requests/${BASE_Upper_singular}Request.php


# Copy & Edit Placeholder Resource
echo "Copy & Edit Placeholder Resource"
docker cp base/Resource.php $CONTAINER:${WORK_DIR}/app/Http/Resources/${BASE_Upper_singular}Resource.php
$DOCKER_EXEC sed -i "s+BASE_Upper_singular+${BASE_Upper_singular}+g" ${WORK_DIR}/app/Http/Resources/${BASE_Upper_singular}Resource.php



###################### ARTISAN MIGRATE #######################
echo "======================================================="
while true; do
    read -p "Migrate:fresh? [y/n]:" yn
    case $yn in
        [Yy]* ) $DOCKER_EXEC php artisan migrate:fresh; break;;
        [Nn]* ) $DOCKER_EXEC php artisan migrate; break;;
        * ) echo "Please answer yes or no [y/n].";;
    esac
done



###################### ROUTING ###############################
echo "======================================================="
echo "Insert Routing into 'api.php'"
$DOCKER_EXEC sed -i "s+//USE_PLACEHOLDER+use App\\\Http\\\Controllers\\\\${BASE_Upper_singular}Controller;\n//USE_PLACEHOLDER+" ${WORK_DIR}/routes/api.php
$DOCKER_EXEC sed -i "s+//ROUTE_PLACEHOLDER+Route::apiResource('${ROUTE}', ${BASE_Upper_singular}Controller::class);\n        //ROUTE_PLACEHOLDER+" ${WORK_DIR}/routes/api.php



###################### TIPS ##################################
# TIPS
echo "======================================================="
echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!"
echo "!ADD CORRECT RELATIONSHIP INSIDE PARENT & CHILD MODELS!"
echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!"
