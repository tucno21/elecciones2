<?php include ext('layoutDash.menuDash') ?>


<footer class="footer-admin mt-auto footer-light">
    <div class="container-xl px-4">
        <div class="row">
            <div class="col-md-6 small">Copyright © Your Website <?= date('Y') ?></div>
        </div>
    </div>
</footer>
</div>
</div>


<?php foreach ($linksScript as $value) : ?>
    <script src="<?= $value ?>"></script>
<?php endforeach; ?>
</body>

</html>