<?php

function json_compact($node, $MAX_LINE) {
  if (!is_array($node) && !($node instanceof stdClass)) {
    // scalar
    $ret = gettype($node) == 'string' ? "\"$node\"" : $node;
    return array($ret, strlen($ret));
  }
  $children = array();
  $multiline = false;
  $totallen = 2;
  if ($node instanceof stdClass) {
    // object
    if (count((array)$node) == 0) { return array("{}", 2); }
    foreach ($node as $key => $val) {
      list($child, $len) = json_compact($val, $MAX_LINE);
      $totallen += count($key) + 6 + $len;
      if (is_array($child)) { $multiline = true; }
      $children[$key] = $child;
    }
    if ($multiline || $totallen >= $MAX_LINE) {
      return array($children, $MAX_LINE);
    }
    $ret = "{ "
    . join(
        ", ",
        array_map(
          function($key) use($children) {
            return "\"$key\": " . $children[$key];
          },
          array_keys($children)
        )
      )
    . " }";
    return array($ret, strlen($ret));

  } else {
    // array
    if (count($node) == 0) { return array("[]", 2); }
    foreach ($node as $val) {
      list($child, $len) = json_compact($val, $MAX_LINE);
      $totallen += $len + 2;
      if (is_array($child)) { $multiline = true; }
      $children[] = $child;
    }
    if ($multiline || $totallen >= $MAX_LINE) {
      return array($children, $MAX_LINE);
    }
    $ret = "[ " . join(", ", $children) . " ]";
    return array($ret, strlen($ret));
  }
}

function my_json_encode($node, $indent=0) {
  $tab = str_repeat(" ", $indent);
  $ttab = $tab . "  ";
  if (!is_array($node)) { return $node; return; }

  $first = true;
  if (!empty(array_diff(array_keys($node), range(0, count($node)-1)))) {
    $ret = "{";
    foreach ($node as $key => $val) {
      if (!$first) $ret .= ",";
      $ret .= "\n$ttab\"$key\": " . my_json_encode($val, $indent+2);
      $first = false;
    }
    return $ret . "\n$tab}";
  }

  $ret = "[";
  foreach ($node as $val) {
    if (!$first) $ret .= ",";
    $ret .= "\n$ttab" . my_json_encode($val, $indent+2);
    $first = false;
  }
  return $ret . "\n$tab]";
}

function json_format_compact($jsonstr, $MAX_LINE=80) {
  return my_json_encode(json_compact(json_decode($jsonstr), $MAX_LINE)[0]);
}
