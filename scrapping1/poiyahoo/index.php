<?php require_once('../Connections/conn.php'); ?>
<?php
mysql_select_db($database_conn, $conn);
$query_rsView = "SELECT count(a.province) as cnt, a.province, b.cnt as cntTotalPoi, d.cnt as cntTotalPoiFound, e.cnt as cnttotalpoinotcompleted, f.cnt as cnttotalpoicompleted, g.cnt as reviewfound FROM us_xml_yahoo as a LEFT JOIN  totalpoi as b ON a.province = b.province LEFT JOIN totalpoicompleted as c ON a.province = c.province LEFT JOIN totalpoifound as d ON a.province = d.province LEFT JOIN totalpoinotcompleted as e ON a.province = e.province LEFT JOIN totalpoicompleted as f ON a.province = f.province LEFT JOIN reviewfound as g ON a.province = g.province GROUP BY a.province";
$rsView = mysql_query($query_rsView, $conn) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Statistics</title>
<style type="text/css">
<!--
body {
	font-family: Verdana;
	font-size: 11px;
}
-->
</style>
</head>

<body>
<h1>Statistics </h1>
<table border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5" align="center"><strong>With Hotel Id </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Count</strong></td>
    <td><strong>Province</strong></td>
    <td><strong>Total Poi in XML </strong></td>
    <td><strong>Total Poi Found </strong></td>
    <td><strong>Poi Not Found </strong></td>
    <td><strong>POI With Review </strong></td>
    <td><strong>POI Without Review </strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php static $no=0; $no++; echo $no; ?>&nbsp;</td>
      <td><?php echo $row_rsView['cnt']; $totcnt += $row_rsView['cnt']; ?></td>
      <td><?php echo $row_rsView['province']; ?></td>
      <td><?php echo $row_rsView['cntTotalPoi']; $totcntPoi += $row_rsView['cntTotalPoi']; ?></td>
      <td><a href="poifound.php?province=<?php echo $row_rsView['province']; ?>" target="_blank"><?php echo $row_rsView['cntTotalPoiFound']; ?>
      <?php if($row_rsView['cntTotalPoi']>0) { ?> [<?php echo number_format(($row_rsView['cntTotalPoiFound']/$row_rsView['cntTotalPoi'])*100,2); ?> %]<?php } ?></a></td>
      <td><a href="nopoifound.php?province=<?php echo $row_rsView['province']; ?>"><?php echo $notfound = $row_rsView['cntTotalPoi']-$row_rsView['cntTotalPoiFound']; ?> <?php if($row_rsView['cntTotalPoi']>0) { ?> [<?php echo number_format(($notfound/$row_rsView['cntTotalPoi'])*100,2); ?> %]<?php } ?></a></td>
      <td><?php echo $row_rsView['reviewfound']; ?>[<?php echo number_format($row_rsView['reviewfound']/$row_rsView['cntTotalPoiFound'])*100,2); ?> %]</td>
      <td><?php echo $noreview = $row_rsView['cntTotalPoiFound']-$row_rsView['reviewfound']; ?>[<?php echo echo number_format($noreview/$row_rsView['cntTotalPoiFound'])*100,2); ?>]</td>
    </tr>
    <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo $totcnt; ?></td>
      <td>&nbsp;</td>
      <td><?php echo $totcntPoi; ?>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsView);
?>
