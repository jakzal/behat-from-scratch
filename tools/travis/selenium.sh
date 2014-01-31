#!/bin/sh

command=${1:-"help"}

SELENIUM_VERSION="2.39.0"
NODE_OPTIONS="-browser browserName=phantomjs"

download() {
  [ -f selenium-server-standalone.jar ] || wget http://selenium.googlecode.com/files/selenium-server-standalone-${SELENIUM_VERSION}.jar -Oselenium-server-standalone.jar
}

start() {
  download
  java -jar selenium-server-standalone.jar > /dev/null 2>&1 &
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

