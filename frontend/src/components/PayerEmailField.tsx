import { Stack, TextField } from '@mui/material'

export const PayerEmailField = () => {
    return (
        <Stack spacing={4}>
            <Stack direction={'row'} spacing={202}>
                <TextField label='Email do Pagador' />
            </Stack>
        </Stack>
    )
}