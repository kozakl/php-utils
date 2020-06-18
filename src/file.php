<?php
namespace kozakl\utils\file;

function pathJoin(...$paths) {
  return preg_replace('#/+#', '/', implode('/', array_filter($paths)));
}
