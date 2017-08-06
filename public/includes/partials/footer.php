<!-- Footer -->
<footer>
    <div class="row">
        <div class="col-lg-12">
            <p>Copyright &copy; by CrikoC, <?php echo date("Y", time()); ?> </p>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="/cms/public/includes/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/cms/public/includes/js/bootstrap.min.js"></script>
</body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>