describe('client side test', () => {
 
  it('should go to setting page when login', () => {
    
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');

    
    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');

   
    cy.get('button[type="submit"]').click();

    
    cy.get('.dropdown-toggle').click();


    cy.contains('.dropdown-menu a', 'Settings').click();

   
    cy.url().should('include', '/pages/settings.php');



});



})


describe('server side test', () => {
  it('should go to setting page and edit the profile', () => {

    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');

  
    cy.get('button[type="submit"]').click();

  
    cy.get('.dropdown-toggle').click();


    cy.contains('.dropdown-menu a', 'Settings').click();

  
    cy.get('input[name="username"]').clear().type('cypress');
    cy.get('input[name="email"]').clear().type('cypress@gmail.com');
    cy.get('input[name="password"]').clear().type('testtest');
    cy.get('input[name="retype_password"]').clear().type('testtest');


    cy.contains('button', 'save').click();
    
    cy.url().should('include', 'home.php');
  });


  it('should go to setting page and should not edit user and have error displayed', () => {

    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');

 
    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');

  
    cy.get('button[type="submit"]').click();

   
    cy.get('.dropdown-toggle').click();

 
    cy.contains('.dropdown-menu a', 'Settings').click();

 
    cy.get('input[name="username"]').clear().type(' ');
    cy.get('input[name="email"]').clear().type(' ');
    cy.get('input[name="password"]').clear().type('testtest');
    cy.get('input[name="retype_password"]').clear().type('testtest');

   
    cy.contains('button', 'save').click();
    
    cy.contains('Please fix the errors below').should('be.visible');
   
  });


  


});
