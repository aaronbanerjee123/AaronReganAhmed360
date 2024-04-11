describe('client side test', () => {
  it('should navigate to the "test test" post page when pressing the title', () => {
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');
  
  
    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');
    cy.get('button[type="submit"]').click();
  

    cy.contains('My Blog').click();
  

    cy.get('.row.g-0.border.rounded.overflow-hidden.flex-md-row.mb-4.shadow-sm.h-md-250.position-relative').should('be.visible');
  
 
    cy.contains('a[href*="test-test"] h3', 'test test').click();
  
  
    cy.url().should('include', 'test-test');
    cy.url().should('eq', 'https://cosc360.ok.ubc.ca/aaron202/app/pages/post.php?slug=test-test');
  });
  


  it('should navigate to edit page when clicking on the edit button', () => {
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');
    cy.get('button[type="submit"]').click();


    cy.contains('My Blog').click();

    cy.get('.row.g-0.border.rounded.overflow-hidden.flex-md-row.mb-4.shadow-sm.h-md-250.position-relative').should('be.visible');


    
  });


})

describe('server side test', () => {
  
  it('should navigate and edit the test test post', () => {
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');
  
   
    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');
    cy.get('button[type="submit"]').click();
  
 
    cy.contains('My Blog').click();
  
    
    cy.get('.row.g-0.border.rounded.overflow-hidden.flex-md-row.mb-4.shadow-sm.h-md-250.position-relative').should('be.visible');
  
   
    cy.get('.btn.btn-sm.btn-primary').eq(0).click();
  
  
    cy.get('input[name="title"]').clear().type('test test');
    cy.get('input[name="content"]').clear().type('test test');
  
   
    cy.contains('button', 'Save').click();
  });
  

})