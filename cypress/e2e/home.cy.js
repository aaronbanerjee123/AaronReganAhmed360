describe('client side testing', () => {


  it('should lead to the login page when "Login" link is clicked', () => {
    
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/home.php');
    cy.contains('Login').click();
    cy.url().should('include', '/pages/login.php');
  });



  it('should lead to the login page when "My Blog" link is clicked and user is not signed up', () => {
    
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/home.php');
    cy.contains('My Blog').click();
    cy.url().should('include', '/pages/login.php');
  });


  it('should lead to the login page when "Add Blog" link is clicked and user is not signed up', () => {
    
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/home.php');
    cy.contains('Add Blog').click();
    cy.url().should('include', '/pages/login.php');
  });

  it('should lead to the homepage when "InSightInk" logo is clicked', () => {
 
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/home.php');
    cy.get('a').contains('InSightInk').click();
    cy.url().should('include', '/pages/home.php');
  });


  it('should navigate to the post page when a post card is clicked', () => {
    
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/home.php');
    cy.contains('h3', 'first blog ever').click();
    cy.url().should('include', '/pages/post.php?slug=first-blog-ever');
  });








 



});


describe('server side testing', () => {

    //when login 

  it('should go to my blog page when login successfully with user_session ', () => {

    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');

    
    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');

    
    cy.get('button[type="submit"]').click();

    cy.contains('My Blog').click();
    cy.url().should('include', '/pages/myblogs.php');
    
  });

  
  it('should go to add blog page when login successfully with user_session', () => {

    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');


    cy.get('button[type="submit"]').click();

    cy.contains('Add Blog').click();
    cy.url().should('include', '/pages/add.php');
    
  });


  




});
