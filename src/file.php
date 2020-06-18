<?php
function pathJoin(...$paths) {
  return preg_replace('#/+#', '/', implode('/', array_filter($paths)));
}
