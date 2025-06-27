<?php

$categoryViewQuery = "SELECT * FROM `categories`";
$categoryViewPrepare = $connect->prepare($categoryViewQuery);
$categoryViewPrepare->execute();

$categoryData = $categoryViewPrepare->fetchAll(PDO::FETCH_ASSOC);



?>

<style>
	.divC{
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
	}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row" style="justify-content: space-evenly; align-items: baseline;">
				<div class="col-sm-6 col-lg-3 p-b-50 divC">
					<h4 class="stext-301 cl0 p-b-30">
						Categories
					</h4>
					<div style="display: flex; gap: 45px;">
						<?php
						// Split the category data into chunks of 5
						$chunkedCategories = array_chunk($categoryData, 6);

						// Loop through each chunk
						foreach ($chunkedCategories as $chunk) {
							echo '<ul>';
							// Loop through each category in the current chunk
							foreach ($chunk as $categoryD) {
								echo '
								<li class="p-b-10">
									<a href="product.php?category=' . htmlspecialchars($categoryD['category_id']) . '" class="stext-107 cl7 hov-cl1 trans-04">
										' . htmlspecialchars($categoryD['category_name']) . '
									</a>
								</li>';
							}
							echo '</ul>';
						}
						?>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50 divC" style="padding-left: 60px;">
					<h4 class="stext-301 cl0 p-b-30">
						Help
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="product.php" class="stext-107 cl7 hov-cl1 trans-04">
								Products 
							</a>
						</li>

						<li class="p-b-10">
							<a href="order.php" class="stext-107 cl7 hov-cl1 trans-04">
								Orders 
							</a>
						</li>

						<li class="p-b-10">
							<a href="track-order.php" class="stext-107 cl7 hov-cl1 trans-04">
								Track Order
							</a>
						</li>

						<li class="p-b-10">
							<a href="contact.php" class="stext-107 cl7 hov-cl1 trans-04">
								Contact
							</a>
						</li>

						<li class="p-b-10">
							<a href="about.php" class="stext-107 cl7 hov-cl1 trans-04">
								About
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50 divC">
					<h4 class="stext-301 cl0 p-b-30">
						GET IN TOUCH
					</h4>

					<p class="stext-107 cl7 size-201" style="text-align: center;">
						Limited Stock Alert! ⚡ Grab your favorites before they sell out. Shop smart, shop fast!
					</p>

					<h5 class="cl7">Visit our social media now.</h5>

					<div class="p-t-27">
						<a href="https://www.facebook.com/" target="_blank" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa-brands fa-facebook"></i>
						</a>

						<a href="https://www.instagram.com/" target="_blank" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa-brands fa-instagram"></i>
						</a>

						<a href="https://www.x.com/" target="_blank" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa-brands fa-twitter"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50 divC">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="Enter Your E-mail Address">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Subscribe
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center">
					Copyright ©2025 All rights reserved
				</p>
			</div>
		</div>
	</footer>