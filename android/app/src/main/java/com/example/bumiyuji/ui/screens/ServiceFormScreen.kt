package com.example.bumiyuji.ui.screens

import android.net.Uri
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.CloudUpload
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import coil.compose.AsyncImage
import com.example.bumiyuji.ui.UiState
import com.example.bumiyuji.ui.components.BumiyujiButton
import com.example.bumiyuji.ui.components.BumiyujiTextField
import com.example.bumiyuji.ui.components.BumiyujiTopBar
import com.example.bumiyuji.ui.theme.GoldAccent
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.ServiceViewModel
import com.example.bumiyuji.util.FileUtils
import com.example.bumiyuji.util.ImageUtils
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody
import okhttp3.RequestBody.Companion.asRequestBody

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ServiceFormScreen(
    viewModel: ServiceViewModel,
    serviceId: Int? = null,
    onNavigateBack: () -> Unit
) {
    var title by remember { mutableStateOf("") }
    var description by remember { mutableStateOf("") }
    var selectedImageUri by remember { mutableStateOf<Uri?>(null) }
    var existingImageUrl by remember { mutableStateOf<String?>(null) }

    val context = LocalContext.current
    val launcher = rememberLauncherForActivityResult(ActivityResultContracts.GetContent()) { selectedImageUri = it }

    LaunchedEffect(serviceId) {
        if (serviceId != null) {
            viewModel.fetchDetail(serviceId)
        }
    }

    val detailState = viewModel.detailUiState
    LaunchedEffect(detailState) {
        if (serviceId != null && detailState is UiState.Success) {
            val service = detailState.data
            title = service.title
            description = service.description ?: ""
            existingImageUrl = service.image_url
        }
    }

    Scaffold(
        topBar = {
            BumiyujiTopBar(
                title = if (serviceId == null) "Tambah Layanan" else "Edit Layanan",
                onBackClick = onNavigateBack
            )
        },
        containerColor = WarmCream
    ) { innerPadding ->
        Column(
            modifier = Modifier
                .padding(innerPadding)
                .fillMaxSize()
                .padding(24.dp)
                .verticalScroll(rememberScrollState()),
            verticalArrangement = Arrangement.spacedBy(20.dp)
        ) {
            BumiyujiTextField(value = title, onValueChange = { title = it }, label = "Judul Layanan *")
            BumiyujiTextField(value = description, onValueChange = { description = it }, label = "Deskripsi", singleLine = false, modifier = Modifier.heightIn(min = 120.dp))

            Column {
                Text(text = "Ikon / Gambar", style = MaterialTheme.typography.titleSmall, fontWeight = FontWeight.Bold)
                Spacer(modifier = Modifier.height(12.dp))
                Box(
                    modifier = Modifier
                        .fillMaxWidth()
                        .height(180.dp)
                        .clip(RoundedCornerShape(16.dp))
                        .background(Color.White)
                        .border(1.dp, Color.Gray.copy(alpha = 0.3f), RoundedCornerShape(16.dp))
                        .clickable { launcher.launch("image/*") },
                    contentAlignment = Alignment.Center
                ) {
                    if (selectedImageUri != null) {
                        AsyncImage(model = selectedImageUri, contentDescription = null, modifier = Modifier.fillMaxSize(), contentScale = ContentScale.Crop)
                    } else if (existingImageUrl != null) {
                        AsyncImage(model = ImageUtils.resolveImageUrl(existingImageUrl), contentDescription = null, modifier = Modifier.fillMaxSize(), contentScale = ContentScale.Crop)
                    } else {
                        Icon(Icons.Default.CloudUpload, contentDescription = null, tint = GoldAccent)
                    }
                }
            }

            Spacer(modifier = Modifier.height(12.dp))

            BumiyujiButton(
                text = "Simpan Perubahan",
                onClick = {
                    val titleBody = RequestBody.create(MultipartBody.FORM, title)
                    val descBody = RequestBody.create(MultipartBody.FORM, description)
                    val imagePart = selectedImageUri?.let { uri ->
                        val file = FileUtils.uriToFile(uri, context)
                        val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                        MultipartBody.Part.createFormData("image", file.name, requestFile)
                    }

                    if (serviceId == null) {
                        viewModel.createService(titleBody, descBody, imagePart, null, null)
                    } else {
                        viewModel.updateService(serviceId, titleBody, descBody, imagePart, null, null)
                    }
                    onNavigateBack()
                },
                isLoading = detailState is UiState.Loading
            )
        }
    }
}
