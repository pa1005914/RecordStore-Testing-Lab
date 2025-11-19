1. require_login() forces the user to have an account the tie the cart and purchases to. The function runs multiple time. If the view or action is not set, to look at the cart or the checkout

2. when the user is taken to the view=login page the partial login_form.php is loaded. If there is any error in the submission of the data from the form an alart is given to the user. If the form is succseful the user's username and password will be taken to the login case in the switch statment and if an error occurs an error message will be given and the user will be taken back to the login page. If sucssesful the user is taken to the list page.

3. An the id of the record, a post that is handled in the index switch statment that if the session value cart is set adds the record id to the cart else creates the session value cart

4. The function comes from data/functions.php. We use and need records_by_ids() becasue in the cart all of the information about the record is there as well and the function is how we get that data.

5. The switch case checkout is ran and foreach id in the session cart creates a purchase in the purchase table for the user the the record id.