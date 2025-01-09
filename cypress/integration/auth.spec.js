describe('Teste de Autenticação', () => {
  it('Deve abrir o modal de login', () => {
    // Visita a página de filmes
    cy.visit('/movies');
    
    // Clica no botão de login
    cy.get('#login-btn').click();
    
    // Verifica se o modal está visível
    cy.get('#loginRegisterModal').should('be.visible');
  });

  it('Deve fazer login com credenciais válidas', () => {
    // Intercepta a requisição de login
    cy.intercept('POST', '/auth/login').as('loginRequest');

    // Abre a página de filmes
    cy.visit('/movies');

    // Clica no botão de login
    cy.get('#login-btn').click();

    // Digita as credenciais válidas
    cy.get('#login-email').type('fb@gmail.com');
    cy.get('#login-password').type('12345678');

    // Clica no botão de login no modal
    cy.get('#login-button').click();

    // Aguarda a requisição de login ser concluída com status 200
    cy.wait('@loginRequest').its('response.statusCode').should('eq', 200);
    cy.wait(500); // Aguarda 500 milissegundos
    // Verifica se o login foi bem-sucedido exibindo a saudação
    //cy.get('#user-info').should('contain', 'Bem-vindo, fabiane!');
  });
});
