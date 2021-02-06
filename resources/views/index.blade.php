@extends('out-master')

@section('content')

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center" style="margin-top: 40px;">
      <div
        class="container d-flex flex-column align-items-center justify-content-center"
        data-aos="fade-up"
      >
        <h1>Gym and Fitness Management Software</h1>
        <h2>
          Join the world's leading platform for health, happiness, and
          performance.
        </h2>
        <a href="#about" class="btn-get-started scrollto">Get Started</a>
        <img
          src="assets/img/fitness.jpg"
          class="img-fluid hero-img"
          alt="fitness-illustration"
          data-aos="zoom-in"
          data-aos-delay="150"
        />
      </div>
    </section>
    <!-- End Hero -->

    <main id="main">
      <!-- ======= About Section ======= -->
      <section id="about" class="about">
        <div class="container">
          <div class="row no-gutters">
            <div
              class="content col-xl-5 d-flex align-items-stretch"
              data-aos="fade-right"
            >
              <div class="content">
                <h3>What we provide?</h3>
                <p>
                  Our Gym management Software is updated with the latest technology and online-services.
                </p>
              </div>
            </div>
            <div
              class="col-xl-7 d-flex align-items-stretch"
              data-aos="fade-left"
            >
              <div class="icon-boxes d-flex flex-column justify-content-center">
                <div class="row">
                  <div
                    class="col-md-6 icon-box"
                    data-aos="fade-up"
                    data-aos-delay="100"
                  >
                    <i class="bx bx-group"></i>
                    <h4>Membership Management</h4>
                    <p>
                      Manage membership with the features like Freeze, Upgrade, Transfer & Terminate. 
                    </p>
                  </div>
                  <div
                    class="col-md-6 icon-box"
                    data-aos="fade-up"
                    data-aos-delay="200"
                  >
                    <i class="bx bx-line-chart"></i>
                    <h4>Reports</h4>
                    <p>
                      See multiple reports from Customer, Staff, Inventory, etc to  analyse your business anyitme.
                    </p>
                  </div>
                  <div
                    class="col-md-6 icon-box"
                    data-aos="fade-up"
                    data-aos-delay="300"
                  >
                    <i class="bx bx-message-alt-detail"></i>
                    <h4>Automated Reminders</h4>
                    <p>
                      Schedule automated Email & SMS to members and lead with points such as renewal due, irregularities, feedbacks and etc.
                    </p>
                  </div>
                  <div
                    class="col-md-6 icon-box"
                    data-aos="fade-up"
                    data-aos-delay="400"
                  >
                    <i class="bx bx-shield"></i>
                    <h4>Access Control</h4>
                    <p>
                      Automate & manage your Gym access on the basis of authorized person.
                    </p>
                  </div>
                </div>
              </div>
              <!-- End .content-->
            </div>
          </div>
        </div>
      </section>
      <!-- End About Section -->

      <!-- ======= Features Section ======= -->
      <section id="features" class="features" data-aos="fade-up">
        <div class="container">
          <div class="section-title">
            <h2>Features</h2>
            <!-- <p>
              Magnam dolores commodi suscipit. Necessitatibus eius consequatur
              ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam
              quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.
              Quia fugiat sit in iste officiis commodi quidem hic quas.
            </p> -->
          </div>

          <div class="row content">
            <div class="col-md-5" data-aos="fade-right" data-aos-delay="100">
              <img src="assets/img/features-1.png" class="img-fluid" alt="" />
            </div>
            <div
              class="col-md-7 pt-4"
              data-aos="fade-left"
              data-aos-delay="100"
            >
              <h3>Dedicated Mobile App</h3>
              <p class="font-italic">
                Mobile Application let your members to stay in control and
                connected from wherever they are.
              </p>
            </div>
          </div>

          <div class="row content">
            <div class="col-md-5 order-1 order-md-2" data-aos="fade-left">
              <img src="assets/img/features-2.png" class="img-fluid" alt="" />
            </div>
            <div class="col-md-7 pt-5 order-2 order-md-1" data-aos="fade-right">
              <h3>SMS & Email Notifications</h3>
              <p class="font-italic">
                Automated and customizable Email & SMS alerts to notify members.
              </p>
            </div>
          </div>

          <div class="row content">
            <div class="col-md-5" data-aos="fade-right">
              <img src="assets/img/features-3.png" class="img-fluid" alt="" />
            </div>
            <div class="col-md-7 pt-5" data-aos="fade-left">
              <h3>Biometric and Scanner Integration</h3>
              <p>
                Install Biometric and Scanner feature to enhance security and
                attendance.
              </p>
            </div>
          </div>

          <div class="row content">
            <div class="col-md-5 order-1 order-md-2" data-aos="fade-left">
              <img src="assets/img/features-4.png" class="img-fluid" alt="" />
            </div>
            <div class="col-md-7 pt-5 order-2 order-md-1" data-aos="fade-right">
              <h3>An ultimate solution for your Business Growth</h3>
              <p>
                Thousands of the world's best fitness clubs and recreation
                centers are using FitnessForce and scaling up the business more
                efficiently.
              </p>
            </div>
          </div>
        </div>
      </section>
      <!-- End Features Section -->

      <!-- ======= Steps Section ======= -->
     {{--  <section id="steps" class="steps">
        <div class="container">
          <div class="row no-gutters" data-aos="fade-up">
            <div
              class="col-lg-4 col-md-6 content-item"
              data-aos="fade-up"
              data-aos-delay="100"
            >
              <span>01</span>
              <h4>Lorem Ipsum</h4>
              <p>
                Ulamco laboris nisi ut aliquip ex ea commodo consequat. Et
                consectetur ducimus vero placeat
              </p>
            </div>

            <div
              class="col-lg-4 col-md-6 content-item"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <span>02</span>
              <h4>Repellat Nihil</h4>
              <p>
                Dolorem est fugiat occaecati voluptate velit esse. Dicta
                veritatis dolor quod et vel dire leno para dest
              </p>
            </div>

            <div
              class="col-lg-4 col-md-6 content-item"
              data-aos="fade-up"
              data-aos-delay="300"
            >
              <span>03</span>
              <h4>Ad ad velit qui</h4>
              <p>
                Molestiae officiis omnis illo asperiores. Aut doloribus vitae
                sunt debitis quo vel nam quis
              </p>
            </div>

            <div
              class="col-lg-4 col-md-6 content-item"
              data-aos="fade-up"
              data-aos-delay="100"
            >
              <span>04</span>
              <h4>Repellendus molestiae</h4>
              <p>
                Inventore quo sint a sint rerum. Distinctio blanditiis deserunt
                quod soluta quod nam mider lando casa
              </p>
            </div>

            <div
              class="col-lg-4 col-md-6 content-item"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <span>05</span>
              <h4>Sapiente Magnam</h4>
              <p>
                Vitae dolorem in deleniti ipsum omnis tempore voluptatem. Qui
                possimus est repellendus est quibusdam
              </p>
            </div>

            <div
              class="col-lg-4 col-md-6 content-item"
              data-aos="fade-up"
              data-aos-delay="300"
            >
              <span>06</span>
              <h4>Facilis Impedit</h4>
              <p>
                Quis eum numquam veniam ea voluptatibus voluptas. Excepturi aut
                nostrum repudiandae voluptatibus corporis sequi
              </p>
            </div>
          </div>
        </div>
      </section> --}}
      <!-- End Steps Section -->

      <!-- ======= Services Section ======= -->
      <section id="services" class="services">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>Stable, Secure and Reliable</h2>
            <p>
              Protecting Your Data Is Our Highest Priority. Your data is your
              property and it should stay like that only. FitnessForce doesn't
              snoop on your data in no situation whatsoever, so that you can be
              assured that your business remains none of our business.
            </p>
          </div>

          <div class="row">
            <div
              class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0"
              data-aos="fade-up"
              data-aos-delay="100"
            >
              <div class="icon-box">
                <div class="icon"><i class="bx bx-lock"></i></div>
                <h4 class="title"><a href="">Information Security</a></h4>
                <p class="description">
                  A complete retainership and protection of all your data within
                  the origin of country.
                </p>
              </div>
            </div>

            <div
              class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <div class="icon-box">
                <div class="icon"><i class="bx bx-network-chart"></i></div>
                <h4 class="title"><a href="">Scalable</a></h4>
                <p class="description">
                  Easy tool to help your business to scale up and grow easily. Squart uses cloud based servies to grow your business on big scale.
                </p>
              </div>
            </div>

            <div
              class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0"
              data-aos="fade-up"
              data-aos-delay="300"
            >
              <div class="icon-box">
                <div class="icon"><i class="bx bx-tachometer"></i></div>
                <h4 class="title"><a href="">99% Uptime Guarantee</a></h4>
                <p class="description">
                  A seemless customer experience with no service interruption on our innovative platform to provide the best streaming services to your customers.
                </p>
              </div>
            </div>

            <div
              class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0"
              data-aos="fade-up"
              data-aos-delay="400"
            >
              <div class="icon-box">
                <div class="icon"><i class="bx bx-coin-stack"></i></div>
                <h4 class="title"><a href="">Disaster Recovery Plan</a></h4>
                <p class="description">
                  Regular backup to keep your data secure from any cyber threat and ensure availability.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End Services Section -->

      <!-- ======= Pricing Section ======= -->
      <section id="pricing" class="pricing section-bg">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>Pricing</h2>
            <p>
              Pick the right plan, that fits your business needs.
            </p>
          </div>

          <div class="row justify-content-center">
            <div
              class="col-lg-4 col-md-6 mt-4 mt-md-0"
              data-aos="zoom-in"
              data-aos-delay="100"
            >
              <div class="box featured">
                <h3>Starter</h3>
                <h4><sup>₹</sup>599<span> / month</span></h4>
                <h3><u>Features</u></h3>
                <ul>
            		<li>Enquiry</li>
                  	<li>Customer Management</li>
                  	<li>Payment and Billing</li>
                  	<li>Attendance</li>
                  	<li>Gym Package Management</li>
                  	<li>Employee Management</li>
                  	<li>Workout & Diet Plan</li>
                  	<li>Email Notification</li>
                  	<li>Smart Dashboard</li>
                  	<li>Dedicated Android & iOS App.</li>
                  	{{-- <li class="na">Massa ultricies mi</li> --}}
                </ul>
                <div class="btn-wrap">
                  <a href="#" class="btn-buy">Coming soon</a>
                </div>
              </div>
            </div>

            <div
              class="col-lg-4 col-md-6 mt-4 mt-lg-0"
              data-aos="zoom-in"
              data-aos-delay="200"
            >
              <div class="box">
                <h3>Premium</h3>
                <h4><sup>₹</sup>899<span style="color:#2d405f"> / month</span></h4>
                <h3><u>Features</u></h3>
                <ul>
                  <li><b>Including Starter+</b></li>
                  <li>Auto Payment Reminder</li>
                  <li>SMS Facility</li>
                  <li>Campaning Offers</li>
                  <li>GYM Promotion</li>
                  <li>New Customer Lead Assignment</li>
                  <li>Employee login ( Multi user )</li>
                  <li>Email Notification</li>
              	  <li>Smart Dashboard</li>
               	  <li>Dedicated Android & iOS App.</li>
                </ul>
                <div class="btn-wrap">
                  <a href="#" class="btn-buy">Coming soon</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End Pricing Section -->

      <!-- ======= Contact Section ======= -->
      <section id="contact" class="contact section-bg">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>Contact</h2>
            <p>
              Our Gym management Software is updated with the latest technology and online-services. To find out more, feel free to contact us.
            </p>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-md-12">
                  <div class="info-box">
                    <i class="bx bx-map"></i>
                    <h3>Our Address</h3>
                    <p>Digha, Patna, Bihar, IN</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="info-box mt-4">
                    <i class="bx bx-envelope"></i>
                    <h3>Email Us</h3>
                    <p>contact@squart.in</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="info-box mt-4">
                    <i class="bx bx-phone-call"></i>
                    <h3>Call Us</h3>
                    <p>+91 821 014 3861<br />+91 821 076 0137<br />+91 985 263 8787</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mt-4 mt-md-0">
              <form
		        action="{{ route('save_contact') }}"
                method="post"
                role="form"
                class="contact_form"
                {{-- class="php-email-form" --}}
              >
              	@csrf
                <div class="form-row">
                  <div class="col-md-6 form-group">
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      id="name"
                      placeholder="Your Name"
                      data-rule="minlen:4"
                      data-msg="Please enter at least 4 chars"
                    />
                    <div class="validate"></div>
                  </div>
                  <div class="col-md-6 form-group">
                    <input
                      type="email"
                      class="form-control"
                      name="email"
                      id="email"
                      placeholder="Your Email"
                      data-rule="email"
                      data-msg="Please enter a valid email"
                    />
                    <div class="validate"></div>
                  </div>
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    name="subject"
                    id="subject"
                    placeholder="Subject"
                    data-rule="minlen:4"
                    data-msg="Please enter at least 8 chars of subject"
                  />
                  <div class="validate"></div>
                </div>
                <div class="form-group">
                  <textarea
                    class="form-control"
                    name="message"
                    rows="5"
                    data-rule="required"
                    data-msg="Please write something for us"
                    placeholder="Message"
                  ></textarea>
                  <div class="validate"></div>
                </div>
                <div class="mb-3">
                  {{-- <div class="loading">Loading</div> --}}
                  {{-- <div class="error-message"></div> --}}
                  {{-- <div class="sent-message">
                    Your message has been sent. Thank you!
                  </div> --}}
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Send Message</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
      <!-- End Contact Section -->
    </main>
    <!-- End #main -->

@endsection
