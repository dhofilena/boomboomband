#!/bin/bash

find ./Results -type f -mtime +1 -exec rm {} \;