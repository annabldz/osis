<main id="main" class="main">

    <div class="pagetitle">
        <h1>Table User</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active">Data User</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    

                        <table class="table datatable" border="1" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col" width="3%">No</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Level</th>

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
                                        <td><img src="<?= base_url('img/'.$value->foto);?>" width="30px"></td>
                                        <td><?= $value->username ?></td>
                                        <td><?= $value->level ?></td>


                                        <td>
                                            <a href="<?= base_url('home/edituser/'.$value->id_user)?>" class="btn btn-warning">
                                                <i class="bx bxs-wrench"></i>
                                                <span>Reset Password</span></a>

                                            </td>
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