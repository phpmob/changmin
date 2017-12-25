#!/usr/bin/env sh
sf="$(which php) ./bin/console"
c="$(which composer)"
root=$PWD
hint="Installation being..\t"
with_asset=0
with_media=0
assets=(admin cms account)

function install()
{
    $c install &&\
        $sf doctrine:database:drop --connection=default --force --if-exists && \
        $sf doctrine:database:create --connection=default && \
        $sf doctrine:schema:update --dump-sql --force
}

function install_media()
{
    $sf doctrine:database:drop --connection=media --force --if-exists && \
    $sf doctrine:database:create --connection=media && \
    $sf doctrine:phpcr:init:dbal --force && \
    $sf doctrine:phpcr:repository:init
}

function install_fixture()
{
    $sf sylius:fixtures:load default -n && \
    $sf cache:clear
}

function usage()
{
    echo ""
    echo "\t-h --help."
    echo "\t-a --asset To install with assets."
    echo "\t-m --media To install with separate media database."
    echo ""
}

while [ "$1" != "" ]; do
    PARAM=`echo $1 | awk -F= '{print $1}'`
    VALUE=`echo $1 | awk -F= '{print $2}'`
    case $PARAM in
        -h | --help)
            usage
            exit
            ;;
        -a | --asset)
            with_asset=1
            hint="Installation being with assets.\t"
            ;;
        -m | --media)
            with_media=1
            hint="Installation being with assets.\t"
            ;;
        *)
            echo "ERROR: unknown parameter \"$PARAM\""
            usage
            exit 1
            ;;
    esac
    shift
done


echo $hint;

install

if [ 1 == $with_media ]; then
    install_media
fi

install_fixture

if [ 1 == $with_asset ]; then
    npm set progress=false
    for i in "${assets[@]}"
    do
        cd "$root/scripts/$i" && rm -rf node_modules && time npm install
    done
    cd $root;
fi
