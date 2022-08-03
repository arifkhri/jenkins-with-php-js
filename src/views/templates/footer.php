

</div>
<!-- ./wrapper -->

<script src="<?= base_url; ?>/js/jquery.min.js"></script>
<script src="<?= base_url; ?>/js/highlight.min.js"></script>
  <?php foreach($data['js'] as $key => $value){ ?>
      <script src="<?= base_url; ?>/js/<?= $value; ?>.min.js"></script>
  <?php } ?> 
</body>
</html>