describe('client side testing ', () => {

  
  it('should lead to the homepage when the logo "InSightInk is clicked', () => {
    
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/home.php');
    cy.get('a').contains('InSightInk').click();
    cy.url().should('include', '/pages/home.php');
  });




  it('should navigate to the signup page when "Signup here" is clicked', () => {
  
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');

    
    cy.contains('Signup here').click();


    cy.url().should('include', '/pages/signup.php');
  });





})




describe('server side testing', () =>{

//sql injections 


it('should successfully sign in with correct credentials and navigate to the home page', () => {
 
  cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


  cy.get('#email').type('cypress@gmail.com');
  cy.get('#password').type('testtest');

  cy.get('button[type="submit"]').click();


  cy.url().should('include', '/pages/home.php');


  cy.request('POST', 'https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php').its('status').should('eq', 200);

});


it('should display an error message for wrong email or password', () => {

  cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


  cy.get('#email').type('incorrect@example.com');
  cy.get('#password').type('incorrectPassword');

  
  cy.get('button[type="submit"]').click();


  cy.get('.text-danger').should('be.visible').and('contain', 'Wrong email or password');
});




})