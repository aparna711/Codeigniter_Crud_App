
$(document).ready(function() {
    // Handle "Register New User" button click
    $('.btn-add-new').click(function(e) {
        e.preventDefault();
        
        // Create modal HTML dynamically
        const modalHTML = `
        <div class="modal-overlay" id="registrationModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Customer Registration</h3>
                    <span class="modal-close">&times;</span>
                </div>
                <div class="modal-body">
                    ${$('body').find('#customerRegistrationForm').length ? '' : getRegistrationFormHTML()}
                </div>
            </div>
        </div>`;

        // Append modal to body
        $('body').append(modalHTML);
        
        // Show modal
        $('#registrationModal').fadeIn(300);
        
        // Initialize date pickers in modal
        initDatePickers();
        
        // Form submission handler
        $('#customerRegistrationForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            submitForm($(this));
        });
    });

    // Close modal functionality
    $(document).on('click', '.modal-close, .modal-overlay', function(e) {
        if (e.target.classList.contains('modal-overlay') || e.target.classList.contains('modal-close')) {
            $('#registrationModal').fadeOut(300, function() {
                $(this).remove();
            });
        }
    });
});

// Registration form HTML template
function getRegistrationFormHTML() {
    return `
    <form action="http://localhost/codeigniter_project/index.php/test/submitForm" method="POST" id="customerRegistrationForm">
        <fieldset>
            <legend>Primary Details</legend>
            <label for="first_name">Enter Your First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="20" required autocomplete="off">
            <br><br>

            <label for="last_name">Enter Your Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="20" required autocomplete="off">
            <br><br>

            <label for="email">Enter Your Email address:</label>
            <input type="email" id="email" name="email" maxlength="50" required autocomplete="off">
            <br><br>

            <label for="phone">Enter Your Phone Number:</label>
            <input type="tel" id="phone" name="phone" maxlength="10" required autocomplete="off" placeholder="e.g., 9978675645">
            <br><br>

            <label for="age">Enter Your Age:</label>
            <input type="number" id="age" name="age" min="18" max="65" required autocomplete="off">
            <br><br>
        </fieldset>

        <hr>

        <fieldset>
            <legend>Access, Status & Dates</legend>
            <label for="from_membership_date">Membership Start Date (From Date):</label>
            <input type="date" id="from_membership_date" name="from_date" required autocomplete="off">
            <br><br>
            
            <label for="to_membership_date">Membership End Date (To Date):</label>
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

            <label for="access_level">Level of Access/Status:</label>
            <select id="access_level" name="access_level" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
                <option value="sales">Sales</option>
            </select>
            <br><br>
            
            <label>Account Status:</label>
            <input type="radio" id="status_active" name="account_status" value="Active" checked>
            <label for="status_active">Active</label>
            <input type="radio" id="status_inactive" name="account_status" value="Inactive">
            <label for="status_inactive">Inactive</label>
            <br><br>

            <label>Gender:</label>
            <input type="radio" id="gender_female" name="gender" value="Female">
            <label for="gender_female">Female</label>
            <input type="radio" id="gender_male" name="gender" value="Male">
            <label for="gender_male">Male</label>
            <br><br>
        </fieldset>

        <hr>

        <fieldset>
            <legend>Product Interest</legend>
            <input type="checkbox" id="interest_product_a" name="product_interest[]" value="Product A">
            <label for="interest_product_a">Product A</label><br>
            <input type="checkbox" id="interest_product_b" name="product_interest[]" value="Product B">
            <label for="interest_product_b">Product B</label><br>
            <input type="checkbox" id="interest_service_c" name="product_interest[]" value="Service C">
            <label for="interest_service_c">Service C</label>
        </fieldset>
        <br>
        <button type="submit">Register Customer</button>
    </form>`;
}

// Initialize date pickers
function initDatePickers() {
    const today = new Date().toISOString().split('T')[0];
    const maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() + 1);
    const maxDateStr = maxDate.toISOString().split('T')[0];
    
    $('#from_membership_date').attr('min', today).attr('max', maxDateStr);
    $('#to_membership_date').attr('min', today).attr('max', maxDateStr);
    
    $('#from_membership_date').off('change').on('change', function() {
        const fromDate = $(this).val();
        $('#to_membership_date').attr('min', fromDate);
    });
}

// Form submission
function submitForm(form) {
    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
            alert('Customer registered successfully!');
            $('#registrationModal').fadeOut(300, function() {
                $(this).remove();
            });
        },
        error: function() {
            alert('Error submitting form. Please try again.');
        }
    });
}
