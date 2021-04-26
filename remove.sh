#!/bin/bash
######################
# USER INPUT
echo "======================================================="
echo "Enter model name to be removed, singular and plural:"
read -e -p "Singular:" BASE_MODEL_SINGULAR
BASE_lower_singular=$(perl -ne 'print lc' <<<"$BASE_MODEL_SINGULAR")
BASE_Upper_singular=$(perl -ne 'print ucfirst' <<<"$BASE_lower_singular")
read -e -p "Plural:" BASE_MODEL_PLURAL
BASE_lower_plural=$(perl -ne 'print lc' <<<"$BASE_MODEL_PLURAL")
BASE_Upper_plural=$(perl -ne 'print ucfirst' <<<"$BASE_lower_plural")

######################
# VARIABLES
CONTAINER="api.guideline.crups"
DOCKER_EXEC="docker exec -it $CONTAINER"  # Leave empty if not working inside docker (linux)

######################
# Delete files
echo "======================================================="
echo "Delete '${BASE_Upper_singular}.php' Model"
$DOCKER_EXEC rm -f /var/www/html/app/Models/${BASE_Upper_singular}.php
echo "Delete 'create_${BASE_lower_plural}_table.php' Migration"
$DOCKER_EXEC find /var/www/html/database/migrations -type f -name "*create_${BASE_lower_plural}_table*" -delete
echo "Delete '${BASE_Upper_singular}Controller.php' Controller"
$DOCKER_EXEC rm -f /var/www/html/app/Http/Controllers/${BASE_Upper_singular}Controller.php
echo "Delete '${BASE_Upper_singular}Policy.php' Policy"
$DOCKER_EXEC rm -f /var/www/html/app/Policies/${BASE_Upper_singular}Policy.php
echo "Delete '${BASE_Upper_singular}Resource.php' Resource"
$DOCKER_EXEC rm -f /var/www/html/app/Http/Resources/${BASE_Upper_singular}Resource.php
echo "Delete '${BASE_Upper_singular}Request.php' Request"
$DOCKER_EXEC rm -f /var/www/html/app/Http/Requests/${BASE_Upper_singular}Request.php
echo "Delete Routing inside 'api.php'"
$DOCKER_EXEC sed -i "/use App\\\Http\\\Controllers\\\\${BASE_Upper_singular}Controller/d" /var/www/html/routes/api.php
$DOCKER_EXEC sed -i "/${BASE_Upper_singular}Controller::class/d" /var/www/html/routes/api.php
