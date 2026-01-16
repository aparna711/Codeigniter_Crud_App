<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$current_gender           = $current_filters['filter_gender']        ?? '';
$current_access_level     = $current_filters['filter_access_level']  ?? '';
$current_id               = $current_filters['filter_id']            ?? '';
$current_age              = $current_filters['filter_age']           ?? '';
$current_membership_from  = $current_filters['membership_from']      ?? '';
$current_membership_to    = $current_filters['membership_to']        ?? '';
$current_country          = $current_filters['filter_country']       ?? '';
$current_status           = $current_filters['filter_status']        ?? '';
$current_search           = $current_filters['search_text']          ?? '';
$current_phone            = $current_filters['filter_phone']         ?? '';
$current_product_interest = $current_filters['product_interest']     ?? [];

$total_count = $total_count ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Data Table</title>
    
    <link rel="stylesheet"  type="text/css" href="<?php echo base_url('assets/css/newdesign.css'); ?>">
     <link rel="stylesheet"  type="text/css" href="<?php echo base_url('assets/css/flash.css'); ?>">
    <link rel="stylesheet"  type="text/css" href="<?php echo base_url('assets/css/download.css'); ?>">
    <link rel="stylesheet"  type="text/css" href="<?php echo base_url('assets/css/delete_pop_up.css'); ?>">
    <link rel="stylesheet"  type="text/css" href="<?php  echo base_url('assets/css/form.css'); ?>">
    <link rel="stylesheet"  type="text/css" href="<?php  echo base_url('assets/css/modal.css'); ?>"> 
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url('assets/css/form.css')?>" ></link> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
</head>
<body>
    <div class="container">
        <!-- PHP Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="flash-message flash-success">
                <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="flash-message flash-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- JavaScript Flash Messages -->
        <div id="flash-messages"></div>

        <!-- Import Modal -->
        <div id="import-modal">
            <div>
                <div id="modal-icon"></div>
                <h3 id="modal-title"></h3>
                <p id="modal-message"></p>
                <button id="modal-close">OK</button>
            </div>
        </div>

        <!-- Register Modal -->
        <div id="registerModal" class="modal">
            <div class="modal-content">
                <button class="close-btn">&times;</button>
                <div class="modal-header">
                    <h2><i class="fas fa-user-plus"></i> Register New Customer</h2>
                </div>
                <form id="customerRegistrationForm">
                    <fieldset>
                        <legend>Primary Details</legend>
                        
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" maxlength="20" required autocomplete="off">
                        <br><br>

                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" maxlength="20" required autocomplete="off">
                        <br><br>

                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" maxlength="50" required autocomplete="off">
                        <br><br>

                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" maxlength="10" required autocomplete="off" placeholder="e.g., 9978675645">
                        <br><br>

                        <label for="age">Age:</label>
                        <input type="number" id="age" name="age" min="18" max="65" required autocomplete="off">
                        <br><br>
                    </fieldset>

                    <hr>

                    <fieldset>
                        <legend>Access, Status & Dates</legend>

                        <label for="from_membership_date">Membership Start Date:</label>
                        <input type="date" id="from_membership_date" name="from_date" required autocomplete="off">
                        <br><br>
                        
                        <label for="to_membership_date">Membership End Date:</label>
                        <input type="date" id="to_membership_date" name="to_date" required autocomplete="off">
                        <br><br>

                        <label for="country">Country:</label>
                        <select id="country" name="country" required>
                            <option value="">Select Country...</option>
                            <option value="1">USA</option>
                            <option value="2">Canada</option>
                            <option value="3">UK</option>
                        </select>
                        <br><br>

                        <label for="access_level">Access Level:</label>
                        <select id="access_level" name="access_level" required>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                            <option value="sales">Sales</option>
                        </select>
                        <br><br>
                        
                        <label>Account Status:</label>
                        <div style="display: inline-block; margin-left: 10px;">
                            <input type="radio" id="status_active" name="account_status" value="Active" checked>
                            <label for="status_active" style="margin-right: 15px;">Active</label>
                            
                            <input type="radio" id="status_inactive" name="account_status" value="Inactive">
                            <label for="status_inactive">Inactive</label>
                        </div>
                        <br><br>

                        <label>Gender:</label>
                        <div style="display: inline-block; margin-left: 10px;">
                            <input type="radio" id="gender_female" name="gender" value="Female">
                            <label for="gender_female" style="margin-right: 15px;">Female</label>

                            <input type="radio" id="gender_male" name="gender" value="Male">
                            <label for="gender_male">Male</label>
                        </div>
                        <br><br>
                    </fieldset>

                    <hr>

                    <fieldset>
                        <legend>Product Interest</legend>
                        <div style="display: flex; gap: 20px; margin-top: 10px;">
                            <label style="display: flex; align-items: center; gap: 5px;">
                                <input type="checkbox" id="interest_product_a" name="product_interest[]" value="Product A">
                                Product A
                            </label>
                            <label style="display: flex; align-items: center; gap: 5px;">
                                <input type="checkbox" id="interest_product_b" name="product_interest[]" value="Product B">
                                Product B
                            </label>
                            <label style="display: flex; align-items: center; gap: 5px;">
                                <input type="checkbox" id="interest_service_c" name="product_interest[]" value="Service C">
                                Service C
                            </label>
                        </div>
                    </fieldset>
                    <br>
                    <div style="text-align: center;">
                        <button type="submit" id="signup" class="btn-apply-modal" style="padding: 12px 40px;">
                            <i class="fas fa-user-plus"></i> Register Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter Modal -->
        <div id="filterModal" class="modal">
            <div class="modal-content filter-modal-content">
                <button class="close-btn">&times;</button>
                <div class="modal-header">
                    <h2><i class="fas fa-filter"></i> Filter Customers</h2>
                </div>
                <form id="filterForm" action="<?php echo base_url('index.php/test/displayData'); ?>" method="POST">
                    <div class="filter-grid">
                        <div class="filter-group-modal">
                            <label for="filter_country">Country:</label>
                            <select id="filter_country" name="filter_country">
                                <option value="">All Countries</option>
                                <option value="1" <?php echo ($current_country == '1' ? 'selected' : ''); ?>>USA</option>
                                <option value="2" <?php echo ($current_country == '2' ? 'selected' : ''); ?>>Canada</option>
                                <option value="3" <?php echo ($current_country == '3' ? 'selected' : ''); ?>>UK</option>
                            </select>
                        </div>

                        <div class="filter-group-modal">
                            <label for="filter_status">Status:</label>
                            <select id="filter_status" name="filter_status">
                                <option value="">All Statuses</option>
                                <option value="Active" <?php echo ($current_status == 'Active' ? 'selected' : ''); ?>>Active</option>
                                <option value="Inactive" <?php echo ($current_status == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="filter-group-modal">
                            <label for="search_text">Search:</label>
                            <input type="text" id="search_text" name="search_text" value="<?php echo html_escape($current_search); ?>" placeholder="Name/Email...">
                        </div>

                        <div class="filter-group-modal">
                            <label for="filter_id">ID:</label>
                            <input type="text" id="filter_id" name="filter_id" value="<?php echo html_escape($current_id); ?>" placeholder="ID">
                        </div>

                        <div class="filter-group-modal">
                            <label>Gender:</label>
                            <div style="display: flex; gap: 10px; margin-top: 5px;">
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="radio" name="filter_gender" value="" <?php echo ($current_gender === '' ? 'checked' : ''); ?>> All
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="radio" name="filter_gender" value="Male" <?php echo ($current_gender === 'Male' ? 'checked' : ''); ?>> Male
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="radio" name="filter_gender" value="Female" <?php echo ($current_gender === 'Female' ? 'checked' : ''); ?>> Female
                                </label>
                            </div>
                        </div>

                        <div class="filter-group-modal">
                            <label for="filter_age">Age:</label>
                            <input type="number" id="filter_age" name="filter_age" min="18" max="100" value="<?php echo html_escape($current_age); ?>" placeholder="25">
                        </div>

                        <div class="filter-group-modal">
                            <label for="filter_phone">Phone:</label>
                            <input type="tel" id="filter_phone" name="filter_phone" value="<?php echo html_escape($current_phone); ?>" maxlength="15">
                        </div>

                        <div class="filter-group-modal">
                            <label for="membership_from">From Date:</label>
                            <input type="date" id="membership_from" name="membership_from" value="<?php echo html_escape($current_membership_from); ?>">
                        </div>

                        <div class="filter-group-modal">
                            <label for="membership_to">To Date:</label>
                            <input type="date" id="membership_to" name="membership_to" value="<?php echo html_escape($current_membership_to); ?>">
                        </div>

                        <div class="filter-group-modal">
                            <label for="filter_access_level">Access Level:</label>
                            <select id="filter_access_level" name="filter_access_level">
                                <option value="">All</option>
                                <option value="Admin" <?php echo ($current_access_level == 'Admin' ? 'selected' : ''); ?>>Admin</option>
                                <option value="Employee" <?php echo ($current_access_level == 'Employee' ? 'selected' : ''); ?>>Employee</option>
                                <option value="Sales" <?php echo ($current_access_level == 'Sales' ? 'selected' : ''); ?>>Sales</option>
                            </select>
                        </div>

                        <div class="filter-group-modal">
                            <label>Interests:</label>
                            <div style="display: flex; flex-direction: column; gap: 5px; margin-top: 5px;">
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="checkbox" name="product_interest[]" value="Product A" <?php echo (in_array('Product A', (array)$current_product_interest) ? 'checked' : ''); ?>> Product A
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="checkbox" name="product_interest[]" value="Product B" <?php echo (in_array('Product B', (array)$current_product_interest) ? 'checked' : ''); ?>> Product B
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="checkbox" name="product_interest[]" value="Service C" <?php echo (in_array('Service C', (array)$current_product_interest) ? 'checked' : ''); ?>> Service C
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="filter-actions-modal">
                        <button type="button" onclick="resetFilters()" class="btn-reset-modal">
                            <i class="fas fa-times"></i> Reset All
                        </button>
                        <button type="submit" class="btn-apply-modal">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal (Will be loaded dynamically) -->
       <!--  <div id="editModal" class="modal">
            <div class="modal-content" id="editModalCont ent">
                
            </div>
        </div> -->


<div id="editModal" class="modal">
            <div class="modal-content" id="edit-modal-content">
                <button class="close-btn">&times;</button>
                <div class="modal-header">
                    <h2><i class="fas fa-filter"></i> Update Customers</h2>
                </div>
    <form id="editCustomerForm" method="POST">
    <input type="hidden" name="id" id="edit_customer_id" value="<?php echo htmlspecialchars($customer->id ?? ''); ?>">
    
    <fieldset>
        <legend>Primary Details</legend>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" maxlength="20" required 
               value="<?php echo set_value('first_name', $customer->first_name ?? ''); ?>">
        <br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" maxlength="20" required 
               value="<?php echo set_value('last_name', $customer->last_name ?? ''); ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" maxlength="50" required 
               value="<?php echo set_value('email', $customer->email ?? ''); ?>">
        <br><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" maxlength="10" required 
               value="<?php echo set_value('phone', $customer->phone ?? ''); ?>" placeholder="9978675645">
        <br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" min="18" max="65" required 
               value="<?php echo set_value('age', $customer->age ?? ''); ?>">
        <br><br>
    </fieldset>

    <hr>

    <fieldset>
        <legend>Access, Status & Dates</legend>
        <label for="from_membership_date">Membership Start:</label>
        <input type="date" id="from_membership_date" name="from_date" required 
               value="<?php echo set_value('from_date', $customer->membership_from ?? ''); ?>">
        <br><br>

        <label for="to_membership_date">Membership End:</label>
        <input type="date" id="to_membership_date" name="to_date" required 
               value="<?php echo set_value('to_date', $customer->membership_to ?? ''); ?>">
        <br><br>

        <label for="country">Country:</label>
        <select id="country" name="country" required>
            <option value="">Select Country...</option>
            <option value="1" <?php echo set_select('country', '1', ($customer->country_id ?? '') == '1'); ?>>USA</option>
            <option value="2" <?php echo set_select('country', '2', ($customer->country_id ?? '') == '2'); ?>>Canada</option>
            <option value="3" <?php echo set_select('country', '3', ($customer->country_id ?? '') == '3'); ?>>UK</option>
        </select>
        <br><br>

        <label for="access_level">Access Level:</label>
        <select id="access_level" name="access_level" required>
            <option value="admin" <?php echo set_select('access_level', 'admin', ($customer->access_level ?? '') == 'admin'); ?>>Admin</option>
            <option value="employee" <?php echo set_select('access_level', 'employee', ($customer->access_level ?? '') == 'employee'); ?>>Employee</option>
            <option value="sales" <?php echo set_select('access_level', 'sales', ($customer->access_level ?? '') == 'sales'); ?>>Sales</option>
        </select>
        <br><br>

        <label>Account Status:</label><br>
        <input type="radio" id="status_active" name="account_status" value="Active" 
               <?php echo set_radio('account_status', 'Active', ($customer->account_status ?? '') == 'Active'); ?>>
        <label for="status_active">Active</label>
        <input type="radio" id="status_inactive" name="account_status" value="Inactive" 
               <?php echo set_radio('account_status', 'Inactive', ($customer->account_status ?? '') == 'Inactive'); ?>>
        <label for="status_inactive">Inactive</label>
        <br><br>

        <label>Gender:</label><br>
        <input type="radio" id="gender_female" name="gender" value="Female" 
               <?php echo set_radio('gender', 'Female', ($customer->gender ?? '') == 'Female'); ?>>
        <label for="gender_female">Female</label>
        <input type="radio" id="gender_male" name="gender" value="Male" 
               <?php echo set_radio('gender', 'Male', ($customer->gender ?? '') == 'Male'); ?>>
        <label for="gender_male">Male</label>
        <br><br>
    </fieldset> 

    <hr>

    <fieldset>
        <legend>Product Interest</legend>
        <?php $interest_array = $customer->product_interest_array ?? []; ?>
        <label><input type="checkbox" name="product_interest[]" value="Product A" 
               <?php echo set_checkbox('product_interest[]', 'Product A', in_array('Product A', $interest_array)); ?>> Product A</label><br>
        <label><input type="checkbox" name="product_interest[]" value="Product B" 
               <?php echo set_checkbox('product_interest[]', 'Product B', in_array('Product B', $interest_array)); ?>> Product B</label><br>
        <label><input type="checkbox" name="product_interest[]" value="Service C" 
               <?php echo set_checkbox('product_interest[]', 'Service C', in_array('Service C', $interest_array)); ?>> Service C</label>
    </fieldset>

    <div style="text-align: center; margin-top: 20px;">
        <button type="submit" id="edit-submit" class="btn-apply-modal" style="padding: 12px 40px;">
            <i class="fas fa-save"></i> Update Customer
        </button>
    </div>
</form>
</div>
</div>

        <div class="header-section">
            <h2>Customer Records (<?php echo $total_count; ?> found)</h2>
            
            <div class="header-actions">
                <button id="openRegisterModal" class="btn-modal">
                    <i class="fas fa-plus-circle"></i> Register New Customer
                </button>
                
                <button id="openFilterModal" class="btn-modal filter">
                    <i class="fas fa-filter"></i> Filter Customers
                </button>
            </div>

            <!-- Current Filters Display -->
            <?php if (!empty(array_filter($current_filters))): ?>
            <div class="current-filters">
                <strong>Active Filters:</strong>
                <?php foreach ($current_filters as $key => $value): ?>
                    <?php if (!empty($value) && !is_array($value)): ?>
                        <span class="filter-tag">
                            <?php echo ucfirst(str_replace('filter_', '', $key)) . ": " . html_escape($value); ?>
                            <span class="remove-filter" onclick="removeFilter('<?php echo $key; ?>')">&times;</span>
                        </span>
                    <?php elseif (is_array($value) && !empty($value)): ?>
                        <span class="filter-tag">
                            <?php echo ucfirst(str_replace('_', ' ', $key)) . ": " . html_escape(implode(', ', $value)); ?>
                            <span class="remove-filter" onclick="removeFilter('<?php echo $key; ?>')">&times;</span>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- CSV Import/Export -->
        <div class="csv-actions" style="margin: 15px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; display: inline-flex; gap: 15px; align-items: flex-start;">
            <div class="import-section" style="position: relative; flex: 1;">
                <a id="import" href="#" class="btn-apply import-btn" onclick="document.getElementById('csv-import').click(); return false;" style="display: block; padding: 12px 20px;">
                    <i id="import" class="fas fa-file-upload"></i> <span id="import" class="import-text">Import CSV</span>
                </a>
                <input type="file" id="csv-import" accept=".csv" style="display: none;">
                
                <div id="filename-display" style="margin-top: 8px; padding: 10px; background: #e9ecef; border-radius: 5px; display: none; font-size: 13px;">
                    <i class="fas fa-file-csv" style="color: #28a745;"></i>
                    <span id="selected-filename" style="margin-left: 8px;"></span>
                    <div style="margin-top: 8px; display: flex; gap: 8px;">
                        <button id="upload-btn" class="btn-apply" style="padding: 6px 16px; font-size: 12px;">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                        <button id="clear-btn" style="padding: 6px 16px; font-size: 12px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            Clear
                        </button>
                    </div>
                </div>
            </div>

            <a href="<?php echo site_url('test/export_csv?' . http_build_query($current_filters)); ?>" 
               class="btn-apply" style="padding: 12px 20px; flex-shrink: 0;">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </div>
        
        <div class="csv-actions" style="margin: 15px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; display: inline-flex; gap: 15px; align-items: flex-start;">
            <p> Searching page <?php echo $current_page ?> of <?php echo $total_pages; ?> </p>
        </div>
<div class="table-wrapper">
        <!-- Table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Age</th>
                    <th>Status</th>
                    <th>Country</th>
                    <th>Access</th>
                    <th>Gender</th>
                    <th>Interests</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                               <!-- <td data-customer-id="<?php //echo $customer->id; ?>"><?php //echo html_escape($customer->id); ?></td>
    <td><?php //echo html_escape($customer->first_name . ' ' . $customer->last_name); ?></td> -->
                             <td data-customer-id="<?php echo $customer->id; ?>"><?php echo html_escape($customer->id); ?></td> 
                            <td><?php echo html_escape($customer->first_name . ' ' . $customer->last_name); ?></td>
                            <td><?php echo html_escape($customer->email); ?></td>
                            <td><?php echo html_escape($customer->phone); ?></td>
                            <td><?php echo html_escape($customer->age ?: '-'); ?></td>
                            <td><?php echo html_escape($customer->account_status ?: '-'); ?></td>
                            <td><?php echo ['','USA','Canada','UK'][$customer->country_id] ?: '-'; ?></td>
                            <td><?php echo html_escape($customer->access_level ?: '-'); ?></td>
                            <td><?php echo html_escape($customer->gender ?: '-'); ?></td>
                            <td>
                                <?php 
                                $interests = $customer->product_interest ? trim($customer->product_interest) : '';
                                
                                if (empty($interests) || $interests === 'None') {
                                    echo 'None';
                                } elseif (strpos($interests, '[') === 0 && strpos($interests, ']') !== false) {
                                    $decoded = json_decode($interests, true);
                                    echo !empty($decoded) && is_array($decoded) ? 
                                         html_escape(implode(', ', $decoded)) : 'None';
                                } else {
                                    $items = array_map('trim', explode(',', $interests));
                                    $items = array_filter($items);
                                    echo !empty($items) ? html_escape(implode(', ', $items)) : 'None';
                                }
                                ?>
                            </td>
                            <td><?php echo html_escape($customer->membership_from); ?></td>
                            <td><?php echo html_escape($customer->membership_to); ?></td>
                            <td>
                                <a href="#" onclick="openEditModal(<?php echo $customer->id; ?>); return false;" class="btn-edit-modal" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?php echo base_url('index.php/test/delete_customer/' . $customer->id); ?>" 
                                   class="btn-delete" onclick="showDeleteConfirm(<?php echo (int)$customer->id; ?>, '<?php echo htmlspecialchars($customer->first_name, ENT_QUOTES); ?>'); return false;" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="13" style="text-align: center; padding: 40px; color: #666;">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                        <div>No customers found matching your criteria</div>
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

        <!-- Pagination -->
        <?php if (!empty($show_pagination) && $show_pagination && isset($total_pages) && $total_pages > 1): ?>
        <div class="pagination-container">
            <div class="pagination">
                <?php 
                $query = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
                $current_page = $current_page ?? 1;
                ?>
                <?php if ($current_page > 1): ?>
                    <a href="<?php echo base_url('index.php/test/displayData' . $query . ($query ? '&' : '?') . 'page=' . ($current_page - 1)); ?>">← Prev</a>
                <?php endif; ?>

                <?php 
                $start = max(1, $current_page - 2);
                $end = min($total_pages, $current_page + 2);
                ?>

                <?php if ($start > 1): ?>
                    <a href="<?php echo base_url('index.php/test/displayData' . $query . ($query ? '&' : '?') . 'page=1'); ?>">1</a>
                    <?php if ($start > 2): ?><span>...</span><?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start; $i <= $end; $i++): ?>
                    <?php $page_query = $query . ($query ? '&' : '?') . 'page=' . $i; ?>
                    <?php if ($i == $current_page): ?>
                        <span class="active"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="<?php echo base_url('index.php/test/displayData' . $page_query); ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($end < $total_pages): ?>
                    <?php if ($end < $total_pages - 1): ?><span>...</span><?php endif; ?>
                    <a href="<?php echo base_url('index.php/test/displayData' . $query . ($query ? '&' : '?') . 'page=' . $total_pages); ?>"><?php echo $total_pages; ?></a>
                <?php endif; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="<?php echo base_url('index.php/test/displayData' . $query . ($query ? '&' : '?') . 'page=' . ($current_page + 1)); ?>">Next →</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="delete-modal">
        <div class="delete-modal-content">
            <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #ff6b35;"></i>
            <h3>Delete Customer?</h3>
            <p>Are you sure you want to delete <strong id="customerName">Customer</strong>?</p>
            <p style="color: #999; font-size: 14px;">This action cannot be undone.</p>
            <div>
                <button id="confirmDeleteBtn" class="delete-btn">Yes, Delete</button>
                <button id="cancelDeleteBtn" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Modal Management
    const registerModal = document.getElementById("registerModal");
    const filterModal = document.getElementById("filterModal");
    const editModal = document.getElementById("editModal");
    
    // Open buttons - FIXED: removed duplicates and typos
    const openRegisterBtn = document.getElementById("openRegisterModal");
    const openFilterBtn = document.getElementById("openFilterModal");
    
    // Open Register Modal
    if (openRegisterBtn) {
        openRegisterBtn.onclick = () => {
            registerModal.style.display = "block";
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Open Filter Modal
    if (openFilterBtn) {
        openFilterBtn.onclick = () => {
            filterModal.style.display = "block";
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Close all modals
    function closeAllModals() {
        registerModal.style.display = "none";
        filterModal.style.display = "none";
        editModal.style.display = "none";
        document.body.style.overflow = 'auto';
    }
    
    // Close buttons
    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.onclick = function() {
            closeAllModals();
        }
    });
    
    // Close modal by clicking outside
    window.onclick = (event) => {
        if (event.target == registerModal || event.target == filterModal || event.target == editModal) {
            closeAllModals();
        }
    }

    // **EDIT MODAL HANDLING - Same pattern as register**
    window.openEditModal = function(customerId) {
        // Populate form with customer data from table row
        populateEditForm(customerId);
        
        // Show modal (same as register)
        editModal.style.display = "block";
        document.body.style.overflow = 'hidden';
    }
    
    

    function populateEditForm(customerId) {
    console.log('Populating for ID:', customerId); // Debug
    
    // Find the row with this customer ID
    const customerRow = document.querySelector(`td[data-customer-id="${customerId}"]`)?.closest('tr');
    if (!customerRow) {
        console.error('Row not found for ID:', customerId);
        return;
    }
    
    const cells = customerRow.querySelectorAll('td');
    console.log('Found cells:', cells.length); // Debug
    
    if (cells.length < 12) {
        console.error('Not enough cells:', cells.length);
        return;
    }
    
    // FIXED column mapping
    document.getElementById('edit_customer_id').value = customerId;
    
    // Split full name (cells[1])
    const fullName = cells[1]?.textContent.trim() || '';
    const nameParts = fullName.split(' ');
    document.getElementById('first_name').value = nameParts[0] || '';
    document.getElementById('last_name').value = nameParts.slice(1).join(' ') || '';
    
    document.getElementById('email').value = cells[2]?.textContent.trim() || '';
    document.getElementById('phone').value = cells[3]?.textContent.trim() || '';
    document.getElementById('age').value = cells[4]?.textContent.trim() || '';
    
    // Status (cells[5])
    const status = cells[5]?.textContent.trim() || 'Active';
    const statusRadio = document.querySelector(`input[name="account_status"][value="${status}"]`);
    if (statusRadio) statusRadio.checked = true;
    
    // Country (cells[6])
    const countryText = cells[6]?.textContent.trim() || '';
    const countryMap = { 'USA': '1', 'Canada': '2', 'UK': '3' };
    document.getElementById('country').value = countryMap[countryText] || '';
    
    // Access level (cells[7]) - lowercase for select value
    const accessLevel = cells[7]?.textContent.trim().toLowerCase() || 'employee';
    document.getElementById('access_level').value = accessLevel;
    
    // Gender (cells[8])
    const gender = cells[8]?.textContent.trim() || 'Male';
    const genderRadio = document.querySelector(`input[name="gender"][value="${gender}"]`);
    if (genderRadio) genderRadio.checked = true;
    
    // Dates (cells[10], cells[11])
    document.getElementById('from_membership_date').value = cells[10]?.textContent.trim() || '';
    document.getElementById('to_membership_date').value = cells[11]?.textContent.trim() || '';
    
    // Reset checkboxes
    document.querySelectorAll('input[name="product_interest[]"]').forEach(cb => cb.checked = false);
    
    console.log('Form populated successfully!'); // Debug
}




    // 1. REGISTER NEW CUSTOMER
    $('#customerRegistrationForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?php // echo base_url("index.php/test/submitForm"); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $('#signup').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Registering...');
            },
            success: function(response) {
                if (response.success) {
                    showFlashMessage('success', response.message);
                    closeAllModals();
                    $('#customerRegistrationForm')[0].reset();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showFlashMessage('error', response.message || 'Registration failed');
                }
            },
            error: function() {
                showFlashMessage('error', 'Registration failed. Please try again.');
            },
            complete: function() {
                $('#signup').prop('disabled', false).html('<i class="fas fa-user-plus"></i> Register Customer');
            }
        });
    });

    // **EDIT FORM SUBMISSION - Exact same pattern as register**
    $('#editCustomerForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const customerId = $('#edit_customer_id').val();
        
        $.ajax({
            url: '<?php echo base_url("index.php/test/update_customer/"); ?>' + customerId,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $('#edit-submit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
            },
            success: function(response) {
                if (response.success) {
                    showFlashMessage('success', response.message);
                    closeAllModals();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showFlashMessage('error', response.message || 'Update failed');
                }
            },
            error: function() {
                showFlashMessage('error', 'Update failed. Please try again.');
            },
            complete: function() {
                $('#edit-submit').prop('disabled', false).html('<i class="fas fa-save"></i> Update Customer');
            }
        });
    });

    // Keep all your existing register, filter, CSV, delete code exactly as is...
    // [Rest of your existing code remains unchanged]
     // 4. FILTER FORM SUBMISSION (AJAX)
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const currentPage = '<?php //echo $current_page ?? 1; ?>';
        
        // Preserve current page if not changing filters significantly
        if (!formData.includes('search_text=') && !formData.includes('filter_')) {
            formData += '&page=' + currentPage;
        }
        
        $.ajax({
            url: '<?php // echo base_url("index.php/test/displayData"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'html',
            beforeSend: function() {
                $('.data-table').html(`
                    <tr><td colspan="13" style="text-align: center; padding: 40px;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 40px;"></i>
                        <p>Applying filters...</p>
                    </td></tr>
                `);
            },
            success: function(data) {
                $('.container').html(data);
            },
            error: function() {
                showFlashMessage('error', 'Filter application failed');
            }
        });
    });

    // 5. RESET FILTERS
    window.resetFilters = function() {
        $('#filterForm')[0].reset();
        $('#filterForm').submit();
    }

    // 6. REMOVE INDIVIDUAL FILTER
    window.removeFilter = function(filterKey) {
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.delete(filterKey);
        currentUrl.searchParams.delete('page'); // Reset to page 1
        
        window.location.href = currentUrl.toString();
    }

    // 7. CSV IMPORT
    $('#csv-import').on('change', function(e) {
        const fileName = e.target.files[0]?.name || '';
        if (fileName) {
            $('#selected-filename').text(fileName);
            $('#filename-display').show();
        }
    });

    $('#upload-btn').on('click', function() {
        const file = $('#csv-import')[0].files[0];
        if (!file) return;
        
        const formData = new FormData();
        formData.append('csv_file', file);
        
        // Add current filters
        <?php //foreach($current_filters as $key => $value): ?>
            <?php //if (!empty($value)): ?>
               // formData.append('<?php //echo $key; ?>', '<?php //echo is_array($value) ? implode(',', $value) : $value; ?>');
            <?php //endif; ?>
        <?php //endforeach; ?>

        $.ajax({
            url: '<?php // echo base_url("index.php/test/import_csv"); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $('#upload-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
            },
            success: function(response) {
                if (response.success) {
                    showFlashMessage('success', response.message);
                    $('#csv-import').val('');
                    $('#filename-display').hide();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showFlashMessage('error', response.message || 'Import failed');
                }
            },
            error: function() {
                showFlashMessage('error', 'Import failed');
            },
            complete: function() {
                $('#upload-btn').prop('disabled', false).html('<i class="fas fa-upload"></i> Upload');
            }
        });
    });

    $('#clear-btn').on('click', function() {
        $('#csv-import').val('');
        $('#filename-display').hide();
    });

    // 8. DELETE CONFIRMATION
    window.showDeleteConfirm = function(customerId, customerName) {
        document.getElementById('customerName').textContent = customerName;
        window.currentDeleteId = customerId;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    $('#confirmDeleteBtn').on('click', function() {
        if (window.currentDeleteId) {
            window.location.href = `<?php echo base_url('index.php/test/delete_customer/'); ?>${window.currentDeleteId}`;
        }
    });

    $('#cancelDeleteBtn, #deleteModal').on('click', function(e) {
        if (e.target.id === 'deleteModal') {
            document.getElementById('deleteModal').style.display = 'none';
        }
    });

    // 9. FLASH MESSAGE HELPER
    function showFlashMessage(type, message) {
        const flashDiv = $('#flash-messages');
        const flashClass = type === 'success' ? 'flash-success' : 'flash-error';
        flashDiv.html(`
            <div class="flash-message ${flashClass}">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                ${message}
            </div>
        `);
        
        setTimeout(() => {
            flashDiv.find('.flash-message').fadeOut();
        }, 5000);
    }

//     // 10. Date validation for register form
//     const today = new Date().toISOString().split('T')[0];
//     $('#from_membership_date').attr('max', today);
//     $('#to_membership_date').attr('max', today);
    
//     // Ensure end date is not before start date
//     $('#from_membership_date').on('change', function() {
//         const fromDate = this.value;
//         $('#to_membership_date').attr('min', fromDate);
//     });
// });
    // Date validation for edit form (same as register)
    const today = new Date().toISOString().split('T')[0];
    $('#from_membership_date, #edit_from_membership_date').attr('max', today);
});
</script>


</body>
</html>
