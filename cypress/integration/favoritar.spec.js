describe('Teste de Favoritar Filmes', () => {
  it('Deve favoritar um filme', () => {
    // Intercepta a requisição de favoritar
  

    // Visita a página de filmes
    cy.visit('/movies');

    // Realiza o login antes de favoritar
    cy.get('#login-btn').click();
    cy.get('#login-email').type('fb@gmail.com');
    cy.get('#login-password').type('12345678');
    cy.get('#login-button').click();
    cy.wait(2400);
    // Aguarda o login ser concluído
    // Pequeno atraso para o login ser processado
    
    cy.intercept('POST', '/favorites').as('favoriteRequest');
    // Seleciona o botão de favoritar do primeiro filme na lista
    cy.get('.favorite-btn').first().as('favoriteButton');
 
    // Clica no botão de favoritar
     cy.get('@favoriteButton').click();
     cy.wait(1200);
    // // Aguarda a requisição de favoritar ser concluída com sucesso
     cy.wait('@favoriteRequest').its('response.statusCode').should('eq', 200);

    // // Verifica se o ícone de coração está na classe 'favorited'
     cy.get('@favoriteButton').find('.heart-icon').should('have.class', 'favorited');
  });

  // it('Deve remover um filme dos favoritos', () => {
  //   // Intercepta a requisição de remover dos favoritos
  //   cy.intercept('DELETE', '/favorites/*').as('unfavoriteRequest');

  //   // Visita a página de filmes
  //   cy.visit('/movies');

  //   // Certifique-se de estar logado
  //   cy.get('#login-btn').click();
  //   cy.get('#login-email').type('fb@gmail.com');
  //   cy.get('#login-password').type('12345678');
  //   cy.get('#login-button').click();

  //   // Aguarda o login ser concluído
  //   cy.wait(500);

  //   // Seleciona o botão de favoritar do primeiro filme na lista
  //   cy.get('.favorite-btn').first().as('favoriteButton');

  //   // Garante que o filme já está favoritado
  //   cy.get('@favoriteButton').find('.heart-icon').should('have.class', 'favorited');

  //   // Clica no botão para desfavoritar
  //   cy.get('@favoriteButton').click();


  //   cy.wait(500);
  //   // Aguarda a requisição de desfavoritar ser concluída com sucesso
  //   cy.wait('@unfavoriteRequest').its('response.statusCode').should('eq', 200);

  //   // Verifica se o ícone de coração não tem mais a classe 'favorited'
  //   cy.get('@favoriteButton').find('.heart-icon').should('not.have.class', 'favorited');
  // });
});
