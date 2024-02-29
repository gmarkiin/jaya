import { Stack, TextField } from '@mui/material'

export const PaymentValueField = () => {
  return (
    <Stack sx={{ marginTop: 2 }}>
      <Stack direction={'row'} spacing={202}>
        <TextField id='card-number-id' label='Valor do pagamento' />
      </Stack>
    </Stack>
  )
}