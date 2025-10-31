<?php
  require 'config/config.php';

  $API_KEY = "YOUR_API_KEY";
  $URL = "https://newsapi.org/v2/top-headlines?country=us&apiKey=".$API_KEY;

  $response = http_request_get($URL);
  $data = json_decode($response, true);

  $filtered = array_filter($data['articles'], function($article) {
    return !empty($article['urlToImage']);
  });

  $articles = $filtered;
  shuffle($articles);

  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>News🔥</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
      href="assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link
      href="assets/vendor/glightbox/css/glightbox.min.css"
      rel="stylesheet"
    />

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: Blogy
  * Template URL: https://bootstrapmade.com/blogy-bootstrap-blog-template/
  * Updated: Feb 22 2025 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  </head>

  <body class="index-page">
    
    <header
      id="header"
      class="header bg-white border-bottom fixed-top"
      style="--bs-bg-opacity: 0.8; backdrop-filter: blur(12px)"
    >
      <div class="container-fluid container-xl position-relative">
        <div class="top-row d-flex align-items-center justify-content-between">
          <a href="index.html" class="logo d-flex align-items-end">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <h1 class="sitename">News</h1>
            <span>.</span>
          </a>

          <div class="d-flex align-items-center">
            <div class="social-links">
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            </div>

            <form class="search-form ms-4">
              <input type="text" placeholder="Search..." class="form-control" />
              <button type="submit" class="btn">
                <i class="bi bi-search"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <main class="main">
      <!-- Category Section Section -->
      <section
        id="category-section"
        class="category-section section"
        style="margin-top: 4rem"
      >

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Hot News🔥</h2>
          <div><span class="description-title">Top Headlines</span></div>
        </div>
        <!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <!-- Featured Posts -->
          <div class="row gy-4 mb-4">

          <?php 
            foreach (array_slice($articles, 0, 3) as $article):
              if (!$article['urlToImage']) continue;
              if (!$article['author']) $article['author'] = "Unknown";
              if (!$article['publishedAt']) $article['publishedAt'] = date('Y-m-d');
          ?>

            <div class="col-lg-4">
              <article class="featured-post">
                <div class="post-img">
                  <img
                    src="<?= $article['urlToImage'] ?>"
                    alt=""
                    class="img-fluid"
                    loading="lazy"
                  />
                </div>
                <div class="post-content">
                  <div class="category-meta">
                    <div class="author-meta">
                      <span class="author-name"><?= $article['author'] ?></span>
                      <span class="post-date"><?= date('M d, Y', strtotime($article['publishedAt'])) ?></span>
                    </div>
                  </div>
                  <h2 class="title">
                    <a href="<?= $article['url'] ?>" target="_blank" rel="noopener noreferrer"
                      ><?= $article['title'] ?></a
                    >
                  </h2>
                </div>
              </article>
            </div>  

          <?php endforeach;?>

          </div>

          <!-- List Posts -->
          <div class="row">
            <?php 
              foreach (array_slice($articles, 3, 6) as $article):
                if (!$article['urlToImage']) continue;
                if (!$article['author']) $article['author'] = "Unknown";
                if (!$article['publishedAt']) $article['publishedAt'] = date('Y-m-d');
            ?>
            <div class="col-xl-4 col-lg-6">
              <article class="list-post">
                <div class="post-img">
                  <img
                    src="<?= $article['urlToImage'] ?>"
                    alt=""
                    class="img-fluid"
                    loading="lazy"
                  />
                </div>
                <div class="post-content">
                  <div class="category-meta">
                    <span class="post-category"><?= $article['source']['name'] ?></span>
                  </div>
                  <h3 class="title">
                    <a href="<?= $article['url'] ?>" target="_blank" rel="noopener noreferrer"
                      ><?= $article['title'] ?></a
                    >
                  </h3>
                  <div class="post-meta">
                    <span class="read-time">2 mins read</span>
                    <span class="post-date"><?= date('M d, Y', strtotime($article['publishedAt'])) ?></span>
                  </div>
                </div>
              </article>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </section>
    </main>

    <footer id="footer" class="footer">
      <div class="container copyright text-center mt-4">
        <p>
          © <span>Copyright</span> <strong class="px-1 sitename">News🔥</strong>
          <span>All Rights Reserved</span>
        </p>
        <div class="credits">
          Designed by <a href="https://github.com/FarisCihuyy">Faris_Cihuyy</a>
        </div>
      </div>
    </footer>

    <!-- Scroll Top -->
    <a
      href="#"
      id="scroll-top"
      class="scroll-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i
    ></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
  </body>
</html>
