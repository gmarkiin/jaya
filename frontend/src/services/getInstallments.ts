import { initMercadoPago, getInstallments } from '@mercadopago/sdk-react';
initMercadoPago('TEST-61dad7ab-6ade-4c83-8f3a-4a0402c57d6a');

export async function fetchInstallmentsOptions(): Promise<string[]> {
    // const amount = document.getElementById('card-number-id') as HTMLInputElement
    // amount?.addEventListener('amount', function (event) {
    //     const target = event.target as HTMLInputElement;
    //     console.log(target.value);
    //   });
    // console.log(amount)
    const installmentsOptions: string[] = []; // Preciso que isso guarde 2 valores - Installment e InstallmentMessage
    const installments = await getInstallments({
        amount: "1000",
        locale: "pt-BR",
        bin: "41111111",
    });
    if (installments && installments.length > 0) {
        const payerCost = installments[0].payer_costs;
        payerCost.forEach(function (value) {
            installmentsOptions.push(value.recommended_message);
        })
    }

    return installmentsOptions
}
