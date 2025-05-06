<?php
// Ambil data dari controller
$penerima = isset($penerima) ? $penerima : [];
$chat = isset($chat) ? $chat : [];
?>

<?php $this->load->view('templates/pasien/header'); ?>
<div class="container mt-4">
    <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert bg-green-100 text-green-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert bg-red-100 text-red-700 p-4 rounded mb-4"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Kirim Pesan</h2>
        <form method="post" action="<?php echo site_url('pasien/kirim_pesan'); ?>">
            <!-- CSRF Token -->
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            
            <div class="form-group">
                <label for="uuid_penerima">Penerima</label>
                <select name="uuid_penerima" id="uuid_penerima" class="form-control w-full p-2 border rounded" required>
                    <option value="">Pilih Penerima</option>
                    <?php foreach ($penerima as $p): ?>
                        <option value="<?php echo $p->uuid; ?>" data-role="<?php echo $p->role; ?>"><?php echo $p->nama; ?> (<?php echo ucfirst($p->role); ?>)</option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="role_penerima" id="role_penerima">
                <?php echo form_error('uuid_penerima', '<small class="text-red-500">', '</small>'); ?>
            </div>
            <div class="form-group mt-4">
                <label for="pesan">Pesan</label>
                <textarea name="pesan" id="pesan" class="form-control w-full p-2 border rounded" required><?php echo set_value('pesan'); ?></textarea>
                <?php echo form_error('pesan', '<small class="text-red-500">', '</small>'); ?>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Kirim</button>
                <a href="<?php echo site_url('pasien'); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 ml-2">Kembali</a>
            </div>
        </form>
    </div>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Riwayat Chat</h2>
        <?php if ($chat): ?>
            <div class="space-y-4">
                <?php foreach ($chat as $item): ?>
                    <div class="p-3 rounded-lg <?php echo $item->pengirim == 'pasien' ? 'bg-indigo-100 ml-auto' : 'bg-gray-100'; ?>">
                        <p><strong><?php echo $item->pengirim == 'pasien' ? 'Anda' : ($item->role_penerima == 'dokter' ? 'Dokter' : 'Bidan'); ?>:</strong> <?php echo $item->pesan; ?></p>
                        <p class="text-sm text-gray-500"><?php echo $item->created_at; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Belum ada pesan.</p>
        <?php endif; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#uuid_penerima').change(function() {
            var role = $(this).find(':selected').data('role');
            $('#role_penerima').val(role);
        });
    });
</script>
<?php $this->load->view('templates/pasien/footer'); ?>