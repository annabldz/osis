<main id="main" class="main">

<section class="section">
    <div class="row">
    <div class="col-lg-12">
   <!--  <div class="card">
    <div class="card-body"> -->
    	
    	<h1 scope="col" width="3%" name="id"> Selamat datang, <?= $anjas->nama_user ?>! </h1>
    	 
 </div>
            </div>
         </div>
    </div>

 <section class="section">
      <div class="row">
        <div class="col-lg-3">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title" class="text-left">Data Kelas ></h5>

              <!-- Multi Columns Form -->
        
                <div class="text-left">
                  <a href="/home/kelas" class="btn btn-primary">Klik</a>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>

        </div>

        <div class="col-lg-3">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title" class="text-left">Data Guru ></h5>

              <!-- Multi Columns Form -->
        
                <div class="text-left">
                  <a href="/home/guru" class="btn btn-primary">Klik</a>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
        </div>
         <div class="col-lg-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title" class="text-left">Data Nilai ></h5>

              <!-- Multi Columns Form -->
        
                <div class="text-left">
                  <a href="/home/nilai" class="btn btn-primary">Klik</a>
                </div>
              </form><!-- End Multi Columns Form -->

            </div>
          </div>
           </div>
      </div>
    </section>

          
<section class="section">
	<div class="row">
        <div class="col-lg-10">
      <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>

              <!-- Slides with indicators -->
              <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="<?= base_url('img/dash.jpeg')?>" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="<?= base_url('img/ea.png')?>" class="d-block w-100" alt="...">
                  </div>
                  
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>

              </div>
            </div>
          </div>