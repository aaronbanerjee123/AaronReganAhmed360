describe('server side tests', () => {
 

  
    it('should not post and show all errors', () => {
      cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');
  

      cy.get('#email').type('cypress@gmail.com');
      cy.get('#password').type('testtest');

      cy.get('button[type="submit"]').click();
  
     
      cy.contains('Add Blog').click();
  
    
      cy.get('form').find('button[type="submit"]').eq(1).click();

      cy.on('window:alert', (text) => { //might need to delete this if removed 
        expect(text).to.equal('hello');
      });
  
      cy.get('.alert').should('have.length', 3);
  
      // Assert each error message
      cy.contains('.alert', 'Post needs an image');
      cy.contains('.alert', 'A title is required');
      cy.contains('.alert', 'Content required');
    });


    it('should add a new blog post with valid data', () => {
      cy.visit('https://cosc360.ok.ubc.ca/aaron202/app/pages/login.php');

    
      cy.get('#email').type('cypress@gmail.com');
      cy.get('#password').type('testtest');
      cy.get('button[type="submit"]').click();

 
      cy.contains('Add Blog').click();

  
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

      cy.get('input[name="title"]').type('cypress post test');


      cy.get('textarea[name="content"]').type('this is a test using cypress . DO NOT DELETE THIS!');

   
      cy.get('form').find('button[type="submit"]').eq(1).click();

      cy.on('window:alert', (text) => {
          expect(text).to.equal('hello');
      });

      cy.get('.alert').should('not.exist'); 
  });
   
  


})