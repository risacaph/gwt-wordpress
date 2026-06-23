<?php
/**
 * The front page template — Barangay San Agustin, Iba, Zambales.
 *
 * WordPress automatically uses front-page.php for the site's homepage,
 * so the barangay design shows immediately after the theme is activated,
 * even before any posts or pages are created.
 *
 * @package GWT
 */

get_header();
?>

<div class="bsa">

  <!-- Hero -->
  <section class="bsa-hero" id="home">
    <div class="wrap">
      <h1><?php esc_html_e( 'Serbisyong Tapat, Malasakit sa Bawat Mamamayan', 'gwt_wp' ); ?></h1>
      <p>Welcome to the official website of Barangay San Agustin &mdash; your gateway to community
         services, programs, and announcements in Iba, the capital town of Zambales.</p>
      <div class="bsa-btnrow">
        <a class="bsa-btn" href="#services"><i class="fa fa-file-text-o"></i> Our Services</a>
        <a class="bsa-btn outline" href="#officials"><i class="fa fa-users"></i> Meet Your Officials</a>
      </div>
    </div>
  </section>

  <!-- Quick services -->
  <section class="bsa-section" id="services">
    <div class="wrap">
      <div class="bsa-head">
        <h2>How Can We Help You?</h2>
        <p>Access the most requested barangay services. Visit the Barangay Hall during office hours to complete your transaction.</p>
      </div>
      <div class="bsa-grid g3">
        <div class="bsa-card"><div class="ic"><i class="fa fa-id-card-o"></i></div><h3>Barangay Clearance</h3><p>Required for employment, business, and other legal transactions within the barangay.</p></div>
        <div class="bsa-card"><div class="ic"><i class="fa fa-home"></i></div><h3>Certificate of Residency</h3><p>Proof that you are a bona fide resident of Barangay San Agustin.</p></div>
        <div class="bsa-card"><div class="ic"><i class="fa fa-heart-o"></i></div><h3>Certificate of Indigency</h3><p>For qualified residents availing of medical, educational, or financial assistance.</p></div>
        <div class="bsa-card"><div class="ic"><i class="fa fa-briefcase"></i></div><h3>Business Permit Endorsement</h3><p>Barangay endorsement needed before securing a municipal business permit.</p></div>
        <div class="bsa-card"><div class="ic"><i class="fa fa-balance-scale"></i></div><h3>Lupong Tagapamayapa</h3><p>Amicable settlement of disputes under the Katarungang Pambarangay system.</p></div>
        <div class="bsa-card"><div class="ic"><i class="fa fa-plus-square"></i></div><h3>Health &amp; Social Services</h3><p>Barangay Health Station, immunization, and assistance programs for residents.</p></div>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <section class="bsa-section bsa-stats">
    <div class="wrap">
      <div class="bsa-grid g4">
        <div class="bsa-stat"><span class="num">1</span><span class="lbl">Barangay</span></div>
        <div class="bsa-stat"><span class="num">7</span><span class="lbl">Sangguniang Kagawad</span></div>
        <div class="bsa-stat"><span class="num">24/7</span><span class="lbl">Barangay Tanod</span></div>
        <div class="bsa-stat"><span class="num">100%</span><span class="lbl">Public Service</span></div>
      </div>
    </div>
  </section>

  <!-- About + vision/mission -->
  <section class="bsa-section alt" id="about">
    <div class="wrap">
      <div class="bsa-two">
        <div class="bsa-prose">
          <h2>About Barangay San Agustin</h2>
          <p>Barangay San Agustin is one of the barangays of the Municipality of Iba, the capital town of the
             Province of Zambales. Nestled along the coastal plains of the West Philippine Sea, the community
             is known for its hospitable residents, agricultural and fishing livelihoods, and strong sense of bayanihan.</p>
          <p>The Barangay Government is committed to transparent, accountable, and responsive governance &mdash;
             bringing essential services closer to every household and building a safe, healthy, and progressive
             community for all.</p>
        </div>
        <div class="bsa-panel">
          <h3><i class="fa fa-bullseye"></i> Our Vision</h3>
          <p>A peaceful, resilient, and progressive Barangay San Agustin with empowered and God-loving citizens
             enjoying a sustainable quality of life under transparent and participative leadership.</p>
          <h3><i class="fa fa-flag-o"></i> Our Mission</h3>
          <p>To deliver responsive basic services, promote peace and order, protect the environment, and uphold
             the welfare of every resident through good governance and active community participation.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Officials -->
  <section class="bsa-section" id="officials">
    <div class="wrap">
      <div class="bsa-head">
        <h2>Your Barangay Officials</h2>
        <p>The Sangguniang Barangay, serving the community of San Agustin with dedication and integrity.</p>
      </div>
      <div class="bsa-grid" style="grid-template-columns:1fr; max-width:360px; margin:0 auto 1.5rem;">
        <div class="bsa-official captain"><div class="av">PB</div><div class="nm">Hon. [Punong Barangay]</div><div class="rl">Punong Barangay (Captain)</div></div>
      </div>
      <div class="bsa-grid g4">
        <div class="bsa-official"><div class="av">K1</div><div class="nm">Hon. [Kagawad 1]</div><div class="rl">Appropriations</div></div>
        <div class="bsa-official"><div class="av">K2</div><div class="nm">Hon. [Kagawad 2]</div><div class="rl">Peace &amp; Order</div></div>
        <div class="bsa-official"><div class="av">K3</div><div class="nm">Hon. [Kagawad 3]</div><div class="rl">Health &amp; Sanitation</div></div>
        <div class="bsa-official"><div class="av">K4</div><div class="nm">Hon. [Kagawad 4]</div><div class="rl">Infrastructure</div></div>
        <div class="bsa-official"><div class="av">K5</div><div class="nm">Hon. [Kagawad 5]</div><div class="rl">Education</div></div>
        <div class="bsa-official"><div class="av">K6</div><div class="nm">Hon. [Kagawad 6]</div><div class="rl">Agriculture</div></div>
        <div class="bsa-official"><div class="av">K7</div><div class="nm">Hon. [Kagawad 7]</div><div class="rl">Environment</div></div>
        <div class="bsa-official"><div class="av">SK</div><div class="nm">Hon. [SK Chairperson]</div><div class="rl">SK Chairperson</div></div>
      </div>
    </div>
  </section>

  <!-- News -->
  <section class="bsa-section alt" id="news">
    <div class="wrap">
      <div class="bsa-head">
        <h2>News &amp; Announcements</h2>
        <p>Stay updated on barangay programs, advisories, and community events.</p>
      </div>
      <div class="bsa-grid g3">
        <article class="bsa-news"><div class="bar"></div><div class="body">
          <span class="date"><i class="fa fa-calendar"></i> June 18, 2026</span>
          <h3>Free Anti-Rabies Vaccination Drive</h3>
          <p>The Barangay Health Station, with the Municipal Veterinary Office, will conduct a free anti-rabies vaccination for pets.</p>
        </div></article>
        <article class="bsa-news"><div class="bar"></div><div class="body">
          <span class="date"><i class="fa fa-calendar"></i> June 10, 2026</span>
          <h3>Coastal Clean-Up Drive</h3>
          <p>Join the monthly coastal clean-up every second Saturday. Help us keep our shoreline clean and protect marine life.</p>
        </div></article>
        <article class="bsa-news"><div class="bar"></div><div class="body">
          <span class="date"><i class="fa fa-calendar"></i> June 1, 2026</span>
          <h3>Barangay Assembly &amp; Budget Hearing</h3>
          <p>All residents are invited to the semi-annual Barangay Assembly to discuss the proposed budget and ongoing projects.</p>
        </div></article>
      </div>
    </div>
  </section>

  <!-- Hotlines -->
  <section class="bsa-section" id="contact">
    <div class="wrap">
      <div class="bsa-head"><h2>Emergency Hotlines</h2></div>
      <div class="bsa-grid g4">
        <div class="bsa-card"><div class="ic"><i class="fa fa-shield"></i></div><h3>Barangay Tanod</h3><p>(047) 000-0000</p></div>
        <div class="bsa-card"><div class="ic"><i class="fa fa-ambulance"></i></div><h3>Health Emergency</h3><p>(047) 000-0001</p></div>
        <div class="bsa-card"><div class="ic"><i class="fa fa-fire-extinguisher"></i></div><h3>Iba Fire Station</h3><p>(047) 811-1234</p></div>
        <div class="bsa-card"><div class="ic"><i class="fa fa-life-ring"></i></div><h3>MDRRMO Iba</h3><p>(047) 811-5678</p></div>
      </div>
      <p style="text-align:center;margin-top:1.5rem;color:#52606d;font-size:0.85rem;">
        <i class="fa fa-info-circle"></i> Names, fees, hotline numbers, and news items above are placeholders for demonstration.
        Update them in the theme files or via the WordPress admin with official barangay information.
      </p>
    </div>
  </section>

</div><!-- .bsa -->

<?php get_footer(); ?>
