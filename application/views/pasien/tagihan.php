
<div class="container mt-4">
    <h1><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal Tagihan</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tagihan): ?>
                        <?php foreach ($tagihan as $t): ?>
                            <tr>
                                <td><?php echo $t->tanggal_tagihan; ?></td>
                                <td><?php echo $t->tanggal_kunjungan; ?></td>
                                <td>Rp <?php echo number_format($t->jumlah, 0, ',', '.'); ?></td>
                                <td><?php echo ucfirst($t->status); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Belum ada tagihan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('templates/pasien/footer'); ?>