<?php
$userName = $_SESSION['apUsername'];
$userId = $_SESSION['apUserId'];
$viewRole = "SELECT * FROM `users` JOIN `roles` ON roles.role_id = users.role_id WHERE user_id = :id";
$viewRolePrepare = $connect->prepare($viewRole);
$viewRolePrepare->bindParam(":id",$userId,PDO::PARAM_INT);
$viewRolePrepare->execute();
$viewRoleData = $viewRolePrepare->fetch(PDO::FETCH_ASSOC);
?>
<nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <!-- <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div> -->
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar rounded-circle bg-dark avatar-online">
                    <h2 class="text-white text-center"><?=$userName[0]?></h2>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                          <div class="avatar rounded-circle bg-dark avatar-online">
                    <h2 class="text-white text-center"><?=$userName[0]?></h2>
                    </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?=$userName?></span>
                            <small class="text-muted"><Strong>Role: </Strong><?=$viewRoleData['role_name']?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages-account-settings-account.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>