import { initMercadoPago, createCardToken, getIdentificationTypes } from '@mercadopago/sdk-react';
initMercadoPago('TEST-61dad7ab-6ade-4c83-8f3a-4a0402c57d6a');

export async function createTokenCard(): Promise<string[]> {
    const installmentsOptions: string[] = [];
    const identificationType = getIdentificationTypes()

    const cardToken = await createCardToken({
        cardholderName: 'Pagamento aprovado',
        identificationType: 'CPF',
        identificationNumber: '12345678909'
      });
    console.log(identificationType)
    // const cardToken  = await createCardToken({
    //     cardId: '5031433215406351',
    //     cardholderName: 'Pagamento aprovado',
    //     identificationType: "CPF",
    //     identificationNumber: '12345678912'
    // });


    return installmentsOptions
}