Cypress.on('uncaught:exception', (err, runnable) => {
  return false;
});

describe('Client side test', () => {
 
 
 
  it('should go to admin page when login as admin', () => {
    
    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');

    
    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');

   
    cy.get('button[type="submit"]').click();

    
    cy.get('.dropdown-toggle').click();


    cy.contains('.dropdown-menu a', 'Admin').click();

   
    cy.url().should('include', '/pages/admin.php');



});


it('should go to admin page when login as admin and then navigate to users page', () => {
 
  cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


  cy.get('#email').type('cypress@gmail.com');
  cy.get('#password').type('testtest');

  cy.get('button[type="submit"]').click();


  cy.get('.dropdown-toggle').click();

  cy.contains('.dropdown-menu a', 'Admin').click();

  cy.contains('.nav-link', 'Users').click();

  cy.url().should('include', '/pages/admin.php?section=users');
});


it('should go to admin page when login as admin and then navigate to posts page', () => {

  cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


  cy.get('#email').type('cypress@gmail.com');
  cy.get('#password').type('testtest');


  cy.get('button[type="submit"]').click();

  cy.get('.dropdown-toggle').click();


  cy.contains('.dropdown-menu a', 'Admin').click();


  cy.contains('.nav-link', 'Posts').click();

  cy.url().should('include', '/pages/admin.php?section=posts');

});





})



describe('server side test', () => {
 

//this is the user from admin

it('should delete user that is made in the test from the admind control', () => {
  cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');
  

  

    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');


    cy.get('button[type="submit"]').click();

    cy.get('.dropdown-toggle').click();


    cy.contains('.dropdown-menu a', 'Admin').click();


    cy.contains('.nav-link', 'Users').click();

    cy.contains('button.btn', 'Add New').click();

    cy.get('input[name="username"]').type('delete');
    cy.get('input[name="email"]').type('delete@gmail.com');
    cy.get('input[name="password"]').type('testtest');
    cy.get('input[name="retype_password"]').type('testtest');

    cy.get('select[name="role"]').select('Admin');

    cy.get('button[type="submit"]').click();


    cy.url().should('include', '/pages/admin.php?section=users');



  });



  it('should go to admin page when login as admin and then navigate to users page, click on an edit button, and save user data', () => {

    cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');

    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');
  

    cy.get('button[type="submit"]').click();
  

    cy.get('.dropdown-toggle').click();
  

    cy.contains('.dropdown-menu a', 'Admin').click();

    cy.contains('.nav-link', 'Users').click();
  

    cy.get('a[href*="action=edit"]').first().click();
  

    cy.get('input[name="username"]').clear().type('delete');
    cy.get('input[name="email"]').clear().type('delete@gmail.com');


    cy.get('select[name="role"]').select('Admin');
  

    cy.get('button[type="submit"]').click();

    cy.url().should('include', '/pages/admin.php?section=users');
  });


 it('should delete user that is made in the test from the admind control', () => {
  cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');
  

  

    cy.get('#email').type('cypress@gmail.com');
    cy.get('#password').type('testtest');

    cy.get('button[type="submit"]').click();

    cy.get('.dropdown-toggle').click();

    cy.contains('.dropdown-menu a', 'Admin').click();


    cy.contains('.nav-link', 'Users').click();

   
    cy.get('a[href*="action=delete"]').first().click(); 


    cy.contains('button', 'Delete').click(); 

    cy.url().should('include', '/pages/admin.php?section=users');



  });


//this is the post for admin 

it('should add new post from admin page' , () => {

  cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


  cy.get('#email').type('cypress@gmail.com');
  cy.get('#password').type('testtest');


  cy.get('button[type="submit"]').click();

  cy.get('.dropdown-toggle').click();


  cy.contains('.dropdown-menu a', 'Admin').click();


  cy.contains('.nav-link', 'Post').click();


  cy.contains('button.btn', 'Add New').click();

  cy.get('input[name="title"]').clear().type('cypress test post from admin');
  cy.get('textarea[name="content"]').clear().type('cypress test post from admin content');

  cy.fixture('test.png', 'base64').then(fileContent => {
    cy.get('input[type="file"]').then($input => {
        const blob = Cypress.Blob.base64StringToBlob(fileContent);
        const file = new File([blob], 'test.png', { type: 'image/png' });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        $input[0].files = dataTransfer.files;
        cy.wrap($input).trigger('change', { force: true });
    });
});


  cy.get('button[type="submit"]').click();


  cy.url().should('include', '/pages/admin.php?section=posts');
});

  

it('should add new post from admin page' , () => {

  cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


  cy.get('#email').type('cypress@gmail.com');
  cy.get('#password').type('testtest');

 
  cy.get('button[type="submit"]').click();


  cy.get('.dropdown-toggle').click();

 
  cy.contains('.dropdown-menu a', 'Admin').click();

  cy.contains('.nav-link', 'Post').click();

  cy.get('a[href*="action=edit"]').first().click();;


  cy.get('input[name="title"]').clear().type('editing test from admin');
  cy.get('input[name="content"]').clear().type('editing test from admin');

  cy.fixture('test.png', 'base64').then(fileContent => {
    cy.get('input[type="file"]').then($input => {
        const blob = Cypress.Blob.base64StringToBlob(fileContent);
        const file = new File([blob], 'test.png', { type: 'image/png' });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        $input[0].files = dataTransfer.files;
        cy.wrap($input).trigger('change', { force: true });
    });
});


  cy.get('button[type="submit"]').click();


  cy.url().should('include', '/pages/admin.php?section=posts');
});

  
it('should delete post from admin page' , () => {
 
  cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');


  cy.get('#email').type('cypress@gmail.com');
  cy.get('#password').type('testtest');


  cy.get('button[type="submit"]').click();


  cy.get('.dropdown-toggle').click();


  cy.contains('.dropdown-menu a', 'Admin').click();


  cy.contains('.nav-link', 'Post').click();


  cy.get('a[href*="action=delete"]').first().click();;

 

  cy.get('button[type="submit"]').click();


  cy.url().should('include', '/pages/admin.php?section=posts');
});







})