<div class="card">
    <div class="card-header">
        <h3 class="card-title">Keluhan</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="sendKomplain.php" id="complaintForm" novalidate="novalidate">
        <div class="card-body" style="display: flex; align-items: flex-start; flex-direction: column;">
            <!-- Kritik Field -->
            <div class="form-group" style="width: 100%; margin-bottom: 20px;">
                <label for="kritik" style="color: #333; font-weight: bold;">Kritik</label>
                <textarea name="kritik" class="form-control" id="kritik" placeholder="Tulis kritik Anda di sini"
                    rows="3" style="width: 100%; resize: none; box-sizing: border-box;"></textarea>
            </div>

            <!-- Saran Field -->
            <div class="form-group" style="width: 100%; margin-bottom: 20px;">
                <label for="saran" style="color: #333; font-weight: bold;">Saran</label>
                <textarea name="saran" class="form-control" id="saran" placeholder="Tulis saran Anda di sini" rows="3"
                    style="width: 100%; resize: none; box-sizing: border-box;"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="form-group" style="width: 100%; text-align: right;">
                <button name="kirim" type="submit" class="btn btn-primary" style="white-space: nowrap;">Kirim</button>
            </div>
        </div>
        <!-- /.card-body -->
    </form>
</div>