describe('Product Search App', () => {
    beforeEach(() => {
        cy.visit('http://127.0.0.1:8000/')
    })

    it('searches for products with an LTV of 80% or more', () => {
        cy.findByLabelText('Property value:').type('100000')
        cy.findByLabelText('Deposit amount:').type('20000')
        cy.findByText('Find products', {selector: 'button'}).click()

        cy.get('.summary').within(() => {
            cy.findByText('80%').should('exist')
            cy.findByText('£80,000.00').should('exist')
        })

        cy.get('.availableProducts').within(() => {
            cy.findByText('Featured product with LTV 80%').should('exist')
            cy.findByText('Featured product with LTV 75%').should('not.exist')
        })
    })

    it('searches for products with an LTV of 75% or more', () => {
        cy.findByLabelText('Property value:').type('200000')
        cy.findByLabelText('Deposit amount:').type('50000')
        cy.findByText('Find products', {selector: 'button'}).click()

        cy.get('.summary').within(() => {
            cy.findByText('75%').should('exist')
            cy.findByText('£150,000.00').should('exist')
        })

        cy.get('.availableProducts').within(() => {
            cy.findByText('Featured product with LTV 80%').should('exist')
            cy.findByText('Normal product with LTV 75%').should('exist')
            cy.findByText('Featured product with LTV 70%').should('not.exist')
        })
    })
})
