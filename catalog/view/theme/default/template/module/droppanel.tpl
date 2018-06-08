<!-- Start Droppanel module -->


<h1 class="text-center">9999999999999999999999999</h1>
<p>despasito</p>


<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content" style="text-align: center;">
  <?php if ($customers) { ?>
    <table cellpadding="2" cellspacing="0" style="width: 100%;">
      <?php foreach ($customers as $customer) { ?>
      <tr><td valign="top"><?php echo $customer['firstname']; ?></td></tr>
      <?php } ?>
    </table>
    <?php } ?>
  </div>
</div>
<!-- End Droppanel module -->