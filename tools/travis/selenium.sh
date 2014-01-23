#!/bin/sh

command=${1:-"help"}

SELENIUM_VERSION="2.39.0"
NODE_OPTIONS="-browser browserName=phantomjs"

download() {
  [ -f selenium-server-standalone.jar ] || wget http://selenium.googlecode.com/files/selenium-server-standalone-${SELENIUM_VERSION}.jar -Oselenium-server-standalone.jar
}

start_hub() {
  echo "Starting the hub"
  java -jar selenium-server-standalone.jar -role hub > /dev/null 2>&1 &
}

start_nodes() {
  nodes=$(sysctl -n hw.ncpu || ( [ -e /proc/cpuinfo ] && grep "^processor" /proc/cpuinfo | wc -l ))
  for i in $(seq 1 $nodes); do
    port=$(expr 5557 + $i)
    echo "Starting node "$i
    java -jar selenium-server-standalone.jar -role node -port $port $NODE_OPTIONS > /dev/null 2>&1 &
    sleep 1
  done
}

start() {
  download
  start_hub
  start_nodes
}

stop() {
  ps ax -o'pid command' | grep selenium-server | grep -v grep | awk '{print $1}' | tr "\n" ' ' | xargs kill -9 &> /dev/null
}

help() {
  echo "Available actions: "
  compgen -A function | tr "\\n" " "
  echo
}

$command

