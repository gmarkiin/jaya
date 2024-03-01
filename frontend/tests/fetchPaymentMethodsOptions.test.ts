import PaymentMethodsService from "../src/services/PaymentMethod/paymentMethod.service"

test('fetchPaymentMethodsOptions returns a string', async () => {
  const bin = '123456'; // Adicione o bin correto para o teste
  const result = await await PaymentMethodsService.fetchPaymentMethods(bin);
  expect(typeof result).toBe('string');
});