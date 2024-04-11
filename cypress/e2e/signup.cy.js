describe('client side test', () => {
  
  


  it('should navigate to the login page when "Login here" is clicked', () => {
   
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/signup.php');


    cy.contains('Login here').click(); 

    
    cy.url().should('include', '/pages/login.php');
});


})


describe('server side test', () => {

  it('should display error messages for required fields when "Create" button is clicked without filling in any fields', () => {
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/signup.php')
    cy.get('button[type="submit"]').click();

    cy.get('.text-danger').should('contain', 'A username is required');
    cy.get('.text-danger').should('contain', 'A email is required');
    cy.get('.text-danger').should('contain', 'A password is required');
  });


  it('should display an error message for an existing email', () => {
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/signup.php')
  
    cy.get('input[name="username"]').type('test');
    cy.get('input[name="email"]').type('test@gmail.com');
    cy.get('input[name="password"]').type('testtest');
    cy.get('input[name="retype_password"]').type('testtest');
    cy.get('input[name="terms"]').check();

    cy.get('button[type="submit"]').click();


    cy.get('.text-danger').should('contain', 'That email is already in use');
  });


  //only works once unless you use an email that hasn't been use 
  // it('should create new account that works', () => {
  //   cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/signup.php');
  
  //   // Fill in the form fields with the provided values
  //   cy.get('input[name="username"]').type('cypress');
  //   cy.get('input[name="email"]').type('cypress@gmail.com');
  //   cy.get('input[name="password"]').type('testtest');
  //   cy.get('input[name="retype_password"]').type('testtest');
  //   cy.get('input[name="terms"]').check();
  
  //   // Upload a PNG image
  //   cy.fixture('test_image.png').then((fileContent) => {
  //     cy.get('input[type="file"]').attachFile({
  //       fileContent: fileContent.toString(),
  //       fileName: 'test_image.png',
  //       mimeType: 'image/png'
  //     });
  //   });
  
  //   // Click the Create button
  //   cy.get('button[type="submit"]').click();
  
  //   // Assert that the URL contains '/pages/home.php' indicating successful account creation
  //   cy.url().should('include', '/pages/home.php');
  // });


})