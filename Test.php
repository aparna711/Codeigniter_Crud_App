<?php
// application/controllers/Test.php
defined('BASEPATH') OR exit('No direct script access allowed');




class Test extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url','form');
        $this->load->model('Customer_data_model');
    }

    //  public function deleteSelected() {
    // // 1. Get the array of IDs from the POST request
    //     $ids = $this->input->post('ids');

    //     if (!empty($ids) && is_array($ids)) {
    //         // 2. Call the model function
    //         $result = $this->customer_model->deleteSelectedRecords($ids);

    //         if ($result) {
    //             echo json_encode(['status' => 'success', 'message' => count($ids) . ' records deleted.']);
    //         } else {
    //             echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    //         }
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'No records selected.']);
    //     }
    // }

    public function deleteSelected() {
    // Collect the IDs sent via AJAX
    $ids = $this->input->post('ids');

    if (!empty($ids) && is_array($ids)) {
        // Call the model function
        $result = $this->Customer_data_model->deleteSelectedRecords($ids);

        if ($result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete from database.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No records selected.']);
    }
}

// public function deleteSelected() {
//     // 1. Get the IDs from the AJAX POST request
//     $ids = $this->input->post('ids');

//     if (!empty($ids)) {
//         // 2. Tell the Model to delete these rows
//         $this->your_model->delete_multiple($ids);

//         // 3. Send success response back to jQuery
//         echo json_encode(['status' => 'success']);
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'No records selected']);
//     }
// }
    
    public function displayData() {
        // Initialize filters array
        $filters = [];
        
        // ✅ Check if this is a POST request (form submission)
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            // Collect filters from POST
            $post_filters = [
                'filter_country' => $this->input->post('filter_country'),
                'filter_status' => $this->input->post('filter_status'),
                'search_text' => $this->input->post('search_text'),
                'filter_id' => $this->input->post('filter_id'),
                'filter_gender' => $this->input->post('filter_gender'),
                'filter_age' => $this->input->post('filter_age'),
                'filter_phone' => $this->input->post('filter_phone'),
                'membership_from' => $this->input->post('membership_from'),
                'membership_to' => $this->input->post('membership_to'),
                'filter_access_level' => $this->input->post('filter_access_level'),
                'product_interest' => $this->input->post('product_interest') ?? [],
            ];
            
            // Build query string and redirect
            $query_string = http_build_query(array_filter($post_filters, function($value) {
                return $value !== '' && $value !== null && $value !== [];
            }));
            
            if ($query_string) {
                redirect("test/displayData?" . $query_string);
            } else {
                redirect('test/displayData3');
            }
            return;
        }
        
        // ✅ If GET request, get filters from URL
        $filters = [
            'country_id'      => $this->input->get('filter_country'),
            'account_status'  => $this->input->get('filter_status'),
            'search_text'     => $this->input->get('search_text'),
            'id'              => $this->input->get('filter_id'),
            'gender'          => $this->input->get('filter_gender'),
            'age'             => $this->input->get('filter_age'),
            'filter_phone'    => $this->input->get('filter_phone'),
            'membership_from' => $this->input->get('membership_from'),
            'membership_to'   => $this->input->get('membership_to'),
            'access_level'    => $this->input->get('filter_access_level'),
            'product_interest'=> $this->input->get('product_interest') ?? [],
        ];
        
        // Handle pagination
        $pagination_data = $this->_handle_pagination($filters);
        
        // Pass data to view - FIXED: Added total_count
        $data = [
            'filters' => $filters,
            'current_filters' => [
                'filter_country' => $this->input->get('filter_country'),
                'filter_status' => $this->input->get('filter_status'),
                'search_text' => $this->input->get('search_text'),
                'filter_id' => $this->input->get('filter_id'),
                'filter_gender' => $this->input->get('filter_gender'),
                'filter_age' => $this->input->get('filter_age'),
                'filter_phone' => $this->input->get('filter_phone'),
                'membership_from' => $this->input->get('membership_from'),
                'membership_to' => $this->input->get('membership_to'),
                'filter_access_level' => $this->input->get('filter_access_level'),
                'product_interest' => $this->input->get('product_interest') ?? [],
            ],
            'total_count' => $pagination_data['total_customers'], // ✅ Added this line
        ];
        
        // Merge pagination data
        $data = array_merge($data, $pagination_data);
        
       // $this->load->view('customer_lists', $data);
         $this->load->view('displaydata3', $data);
    }
    
    private function _handle_pagination($filters) {
        $per_page = 10;
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;
        
        $customers = $this->Customer_data_model->get_filtered_customers($filters, $per_page, $offset);
        $total_count = $this->Customer_data_model->get_filtered_count($filters);
        
        $has_filters = !empty(array_filter($filters));
        $show_pagination = $total_count > $per_page;
        
        return [
            'customers' => $customers,
            'total_customers' => $total_count, // ✅ This is $total_count
            'current_page' => $page,
            'per_page' => $per_page,
            'total_pages' => ceil($total_count / $per_page),
            'has_filters' => $has_filters,
            'show_pagination' => $show_pagination
        ];
    }

public function deleteAllRecords(){
    // 1. Call the model method
    $result = $this->Customer_data_model->deleteAllRecords();

    // 2. Prepare JSON response
    if ($result) {
        $response = [
            'success' => true, 
            'message' => 'All records have been cleared.'
        ];
    } else {
        $response = [
            'success' => false, 
            'message' => 'Failed to delete records.'
        ];
    }

    // 3. Output as JSON for the AJAX 'success' callback
    echo json_encode($response);
}
   

public function import_csv() {
    $this->load->library('upload');
    
    // Upload config
    $config['upload_path'] = './uploads/csv/';
    $config['allowed_types'] = 'csv';
    $config['max_size'] = 2048; // 2MB
    $config['encrypt_name'] = TRUE;
    
    if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
    }
    
    $this->upload->initialize($config);
    
    // STEP 1: Upload file
    if (!$this->upload->do_upload('csv_file')) {
        echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
        return;
    }
    
    // STEP 2: Get file info
    $upload_data = $this->upload->data();
    $csv_file = fopen($upload_data['full_path'], 'r');
    
    // Skip header row
    $header = fgetcsv($csv_file);
    
    $batch_data = [];
    $inserted = 0;
    $skipped = 0;
    
    // STEP 3: Process each row
    while (($row = fgetcsv($csv_file)) !== FALSE) {
        if (count($row) < 4) { // Skip incomplete rows
            $skipped++;
            continue;
        }
        
        $customer_data = [
            'first_name' => trim($row[0]),
            'last_name' => trim($row[1]),
            'email' => trim($row[2]),
            'phone' => trim($row[3]),
            'age' => isset($row[4]) ? (int)$row[4] : NULL,
            'membership_from' => isset($row[5]) ? $row[5] : date('Y-m-d'),
            'membership_to' => isset($row[6]) ? $row[6] : date('Y-m-d', strtotime('+1 year')),
            'country_id' => isset($row[7]) ? (int)$row[7] : NULL,
            'access_level' => isset($row[8]) ? $row[8] : NULL,
            'account_status' => isset($row[9]) ? $row[9] : 'active',
            'gender' => isset($row[10]) ? $row[10] : NULL,
            'product_interest' => isset($row[11]) ? $row[11] : NULL
        ];
        
        // STEP 4: Validate required fields
        if (empty($customer_data['first_name']) || 
            empty($customer_data['last_name']) || 
            empty($customer_data['email']) || 
            empty($customer_data['phone'])) {
            $skipped++;
            continue;
        }
        
        $batch_data[] = $customer_data;
        
        // STEP 5: Batch insert every 100 rows
        if (count($batch_data) >= 100) {
            $this->Customer_data_model->insert_batch_customers($batch_data);
            $inserted += count($batch_data);
            $batch_data = [];
        }
    }
    
    // STEP 6: Insert remaining records
    if (!empty($batch_data)) {
        $this->Customer_data_model->insert_batch_customers($batch_data);
        $inserted += count($batch_data);
    }
    
    // STEP 7: Cleanup
    fclose($csv_file);
    unlink($upload_data['full_path']);
    
    // STEP 8: JSON response
    echo json_encode([
        'status' => 'success', 
        'message' => "Inserted: $inserted, Skipped: $skipped",
        'filename' => $upload_data['file_name']
    ]);
}

public function export_csv() {
    $this->load->dbutil();
    
    // Get current filters from GET parameters (same as displayData)
    $filters = [
        'country_id'      => $this->input->get('filter_country'),
        'account_status'  => $this->input->get('filter_status'),
        'search_text'     => $this->input->get('search_text'),
        'id'              => $this->input->get('filter_id'),
        'gender'          => $this->input->get('filter_gender'),
        'age'              => $this->input->get('filter_age'),
        'phone'           => $this->input->get('filter_phone'),  // Fixed key
        'membership_from' => $this->input->get('membership_from'),
        'membership_to'   => $this->input->get('membership_to'),
        'access_level'    => $this->input->get('filter_access_level'),
        'product_interest'=> $this->input->get('product_interest') ? explode(',', $this->input->get('product_interest')) : [],
    ];
    
    // ✅ FIXED: Get QUERY OBJECT (not result array)
    $query = $this->Customer_data_model->get_csv_all_customers($filters);
    
    // ✅ Handle empty results
    if ($query->num_rows() == 0) {
        $csv_content = "id,first_name,last_name,email,phone,age,membership_from,membership_to,country_id,access_level,account_status,gender,product_interest\r\nNo data found with current filters.\r\n";
    } else {
        $delimiter = ',';
        $newline = "\r\n";
        $enclosure = '"';
       // $csv_content = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);
        // ✅ FIXED: Remove trailing newline/blank line
        $csv_content = rtrim($this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure));
    }


    
    // Set headers for CSV download
    $filename = 'customers_' . date('Y-m-d_H-i-s') . '.csv';
    $this->output
         ->set_content_type('text/csv')
         ->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
         ->set_header('Cache-Control: max-age=0')
         ->set_header('Pragma: public')
         ->set_header('Expires: 0')
         ->_display($csv_content);
}




    public function delete_customer($customer_id) {
        // 1. Check if the ID is valid (optional but recommended)
        if (!is_numeric($customer_id)) {
            // Handle error or redirect
            redirect('test/displayData'); // Redirect back to a safe page
            return;
        }

        // 2. Call the Model to execute the deletion
        $success = $this->Customer_data_model->delete($customer_id);

        // 3. Set a flash message and redirect
        if ($success) {
            // Set success message
            $this->session->set_flashdata('success', 'Customer deleted successfully.');
        } else {
            // Set error message
            $this->session->set_flashdata('error', 'Error deleting customer.');
        }

        // 4. Redirect back to the customer list page
        redirect('test/displayData'); 
    }


// Function to handle Edit (load and save)
public function edit_customer($customer_id = NULL) {
    if ($customer_id === NULL || !is_numeric($customer_id)) {
        $this->session->set_flashdata('error', 'Invalid customer ID.');
        redirect('test/displayData');
    }



    // --- 1. Handle Form Submission (POST Request) ---
    if ($this->input->post()) {
        $updated_data = array(
            'first_name'        => $this->input->post('first_name'),
            'last_name'         => $this->input->post('last_name'),
            'email'             => $this->input->post('email'),
            'phone'             => $this->input->post('phone'),
            'age'               => $this->input->post('age'),
            'membership_from'   => $this->input->post('from_date'),    // ✅ FIXED: matches DB column
            'membership_to'     => $this->input->post('to_date'),      // ✅ FIXED: matches DB column
            'country_id'        => $this->input->post('country'),      // ✅ FIXED: matches DB column
            'access_level'      => $this->input->post('access_level'),
            'account_status'    => $this->input->post('account_status'),
            'gender'            => $this->input->post('gender'),
            'product_interest'  => json_encode($this->input->post('product_interest') ?: []), // ✅ JSON format
            'updated_at'        => date('Y-m-d H:i:s')                 // ✅ Update timestamp
        );

        // Remove empty values
        $updated_data = array_filter($updated_data, function($value) {
            return $value !== '' && $value !== null;
        });

        $success = $this->Customer_data_model->update_customer($customer_id, $updated_data);

        if ($success) {
            $this->session->set_flashdata('success', 'Customer updated successfully.');
            redirect('test/displayData');
        } else {
            $this->session->set_flashdata('error', 'Error updating customer.');
        }
    } 

    // --- 2. Handle Initial Page Load (GET Request) ---
    $data['customer'] = $this->Customer_data_model->get_customer($customer_id);
    
    if (!$data['customer']) {
        $this->session->set_flashdata('error', 'Customer not found.');
        redirect('test/displayData');
    }

    // ✅ Convert JSON product_interest to array for checkboxes
    $data['customer']->product_interest_array = json_decode($data['customer']->product_interest, TRUE) ?: [];

    $this->load->view('editPage', $data); 
}

    

   public function submitForm() {
    $data_to_save = array(
        'first_name' => $this->input->post('first_name'),
        'last_name' => $this->input->post('last_name'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'age' => $this->input->post('age'),
        'membership_from' => $this->input->post('from_date'),
        'membership_to' => $this->input->post('to_date'),
        'country_id' => $this->input->post('country'),
        'access_level' => $this->input->post('access_level'),
        'account_status' => $this->input->post('account_status'),
        'gender' => $this->input->post('gender'),
        'product_interest' => json_encode($this->input->post('product_interest') ?: [])
    );

    $this->load->model('Customer_data_model'); 

    if ($this->Customer_data_model->insert_customer($data_to_save)) {
        echo json_encode(['success' => true, 'message' => 'Customer registered successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insertion failed']);
    }
}

   public function crudApp(){
            $this->load->view('form');
         }
 

public function get_customer($id) {
    // Validate input
    if (!is_numeric($id) || $id <= 0) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode(['error' => 'Invalid customer ID']));
    }
    
    $id = (int)$id;
    
    // Log request
    log_message('info', "Fetching customer ID: {$id}");
    
    // Fetch customer
    $customer = $this->Customer_data_model->get_by_customerid($id);
    
    if (!$customer) {
        log_message('warning', "Customer ID: {$id} not found");
        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode(['error' => 'Customer not found']));
    }
    
    // // Process product interest
    // if (!empty($customer->product_interest) && is_string($customer->product_interest)) {
    //     // Trim whitespace from each value
    //     $customer->product_interest = array_map('trim', explode(',', $customer->product_interest));
    //     // Filter out empty values
    //     $customer->product_interest = array_filter($customer->product_interest);
    // } else {
    //     $customer->product_interest = [];
    // }


    // Process product interest inside get_customer()
    if (!empty($customer->product_interest)) {
        if (is_string($customer->product_interest)) {
            $customer->product_interest = array_filter(array_map('trim', explode(',', $customer->product_interest)));
        }
    } else {
        $customer->product_interest = []; // Always return an empty array if nothing exists
    }


    
    // Log successful retrieval
    log_message('info', "Successfully retrieved customer ID: {$id}");
    
    // Return JSON response
    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($customer));
}





// UPDATE customer (AJAX endpoint)
public function update_customer($customer_id = NULL) {
    if ($customer_id === NULL || !is_numeric($customer_id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid customer ID']);
        return;
    }
    
    $this->load->library('form_validation');
    
    // Set validation rules
    $this->form_validation->set_rules('first_name', 'First Name', 'required|alpha|max_length[20]');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('phone', 'Phone', 'required|exact_length[10]|numeric');
    $this->form_validation->set_rules('age', 'Age', 'required|integer|greater_than_equal_to[18]|less_than_equal_to[65]');
    
    if ($this->form_validation->run() == FALSE) {
        echo json_encode(['success' => false, 'message' => validation_errors()]);
        return;
    }
    
    $updated_data = [
        'first_name' => $this->input->post('first_name'),
        'last_name' => $this->input->post('last_name'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'age' => $this->input->post('age'),
        'membership_from' => $this->input->post('from_date'),
        'membership_to' => $this->input->post('to_date'),
        'country_id' => $this->input->post('country'),
        'access_level' => $this->input->post('access_level'),
        'account_status' => $this->input->post('account_status'),
        'gender' => $this->input->post('gender'),
        'product_interest' => json_encode($this->input->post('product_interest') ?: []),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $this->load->model('Customer_data_model');
    $success = $this->Customer_data_model->update_customer($customer_id, $updated_data);
    
    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Customer updated successfully!' : 'Failed to update customer'
    ]);
}


}