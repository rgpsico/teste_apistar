describe('Teste de Filmes', () => {
    beforeEach(() => {
      cy.visit('/movies'); // Navega para a página de filmes antes de cada teste
    });
  
    it('Deve carregar a lista de filmes', () => {
      cy.get('table tbody tr').should('have.length.greaterThan', 0); // Verifica se a tabela tem linhas
    });
  
    // it('Deve favoritar um filme ao clicar no botão de favorito', () => {
    //   cy.get('.favorite-btn').first().click(); // Clica no primeiro botão de favorito
    //   cy.get('.heart-icon.favorited').should('exist'); // Verifica se o ícone foi marcado como favoritado
    // });
  
    it('Deve abrir o modal de favoritos', () => {
      cy.get('#favorites-btn').click(); // Clica no botão de favoritos
      cy.get('#favoritesModal').should('be.visible'); // Verifica se o modal está visível
    });
  });
  