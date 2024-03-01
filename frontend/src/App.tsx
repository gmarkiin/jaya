import { Button, Grid, Paper, Box } from "@mui/material";
import { useState } from "react";
import React from "react"
import { createCardToken } from "@mercadopago/sdk-react/coreMethods";
import { PayerForm } from "./containers/PayerForm";
import { CardForm } from "./containers/CardForm";
import { useCardStore, usePaymentStore } from "./store"; 
import PaymentMethodsService from "./services/PaymentMethod/paymentMethod.service";
function App() {
  const [loading, setLoading] = useState(false);
  const { cardData } = useCardStore();
  const { paymentData } = usePaymentStore();

  const handlePayment = async () => {
    setLoading(true);
    try {
      const cardTokenResponse = await createCardToken({
        cardNumber: cardData.cardNumber,
        cardholderName: cardData.cardholderName,
        cardExpirationMonth: cardData.cardExpirationMonth,
        cardExpirationYear: cardData.cardExpirationYear,
        securityCode: cardData.securityCode,
        identificationNumber: cardData.identificationNumber,
        identificationType: cardData.identificationType,
      });
      const tokenCard = cardTokenResponse ? cardTokenResponse.id : '';

      const paymentMethodResponse = await PaymentMethodsService.fetchPaymentMethods(cardData.cardNumber.substring(0, 8));
      const paymentMethodId = paymentMethodResponse?.results[0]?.id ?? '';

      const response = await fetch('http://localhost:8080/api/rest/payments/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          transaction_amount: paymentData.transactionAmount,
          installments: paymentData.installments,
          token: tokenCard,
          payment_method_id: paymentMethodId,
          payer: paymentData.payer,
        }),
      });

      if (response.ok) {
        console.log('Payment successful');
      } else {
        console.error('Payment failed:', response.statusText);
      }
    } catch (error) {
      console.error('Error handling payment:', error);
    } finally {
      setLoading(false);
    }
  };

  return (
    <Grid
      container
      sx={{
        marginLeft: '20vw',
        marginTop: 5,
        alignContent: "center",
      }}
      spacing={2}
    >
      <Grid item xs={6}>
        <Box display="flex" justifyContent="space-between">
          <Box maxWidth="35vw"  height="100%">
            <Paper elevation={3} sx={{ padding: 2 }}>
              <PayerForm />
            </Paper>
          </Box>

          <Box maxWidth="30vw"  height="100%">
            <Paper elevation={3} sx={{ padding: 2 }}>
              <CardForm />
            </Paper>
          </Box>
        </Box>
        <Button sx={{ marginLeft: '25vw', marginTop: 5}}
          disabled={loading}
          color="success"
          variant="contained"
          onClick={handlePayment}
        >
          {loading ? 'Processando...' : 'Pagar'}
        </Button>
      </Grid>
    </Grid>
  );
}

export default App;
