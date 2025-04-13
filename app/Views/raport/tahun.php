<main id="main" class="main">

<div class="pagetitle">
    <h1>Table Blok</h1>
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active">Data Guru</li>
        </ol>
        </nav>
</div>

<section class="section">
    <div class="row">
    <div class="col-lg-12">
    <div class="card">
    <div class="card-body">
        <button class="btn btn-success mb-3"><a href="/home/tb" class="text-white">Tambah</a></button>


            <table class="table datatable" border="1" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col" width="3%">No</th>
                    <th scope="col">Tahun Ajaran</th>
                    
                    <th scope="col">Aksi</th>         
                </tr>
            </thead>

            <tbody>
            <?php 
            $ms = 1;
            foreach ($anjas as $key => $value) {
            ?>
                <tr>
                    <th scope="row"><?= $ms++ ?></th>
                    <td><?= $value->nama_tahun ?></td>
                    

                    <td>
                    <a href="<?= base_url('home/rombel/'.$value->id_kelas)?>" class="btn btn-warning">Lihat</a>
                
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            </table>
                        <!-- End Table with stripped rows -->

                </div>
            </div>
         </div>
    </div>
</section>

</main><!-- End #main -->