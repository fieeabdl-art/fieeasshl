package com.example.bumiyuji.ui.screens

import android.net.Uri
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.CircleShape
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
import com.example.bumiyuji.ui.viewmodel.PortfolioViewModel
import com.example.bumiyuji.util.FileUtils
import com.example.bumiyuji.util.ImageUtils
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody
import okhttp3.RequestBody.Companion.asRequestBody

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun PortfolioFormScreen(
    viewModel: PortfolioViewModel,
    portfolioId: Int? = null,
    onNavigateBack: () -> Unit
) {
    var title by remember { mutableStateOf("") }
    var description by remember { mutableStateOf("") }
    var category by remember { mutableStateOf("rumah") }
    var selectedImageUri by remember { mutableStateOf<Uri?>(null) }
    var existingImageUrl by remember { mutableStateOf<String?>(null) }

    val context = LocalContext.current

    val launcher = rememberLauncherForActivityResult(
        contract = ActivityResultContracts.GetContent()
    ) { uri: Uri? ->
        selectedImageUri = uri
    }

    LaunchedEffect(portfolioId) {
        if (portfolioId != null) {
            viewModel.fetchDetail(portfolioId)
        }
    }

    val detailState = viewModel.detailUiState
    LaunchedEffect(detailState) {
        if (portfolioId != null && detailState is UiState.Success) {
            val portfolio = detailState.data
            title = portfolio.title
            description = portfolio.description ?: ""
            category = portfolio.category
            existingImageUrl = portfolio.image_url
        }
    }

    Scaffold(
        topBar = {
            BumiyujiTopBar(
                title = if (portfolioId == null) "Tambah Portfolio" else "Edit Portfolio",
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
            BumiyujiTextField(
                value = title,
                onValueChange = { title = it },
                label = "Judul Proyek"
            )

            Column {
                Text(text = "Kategori", style = MaterialTheme.typography.titleSmall, fontWeight = FontWeight.Bold)
                Spacer(modifier = Modifier.height(8.dp))
                Row(horizontalArrangement = Arrangement.spacedBy(8.dp)) {
                    CategoryChip(selected = category == "rumah", text = "Rumah", onClick = { category = "rumah" })
                    CategoryChip(selected = category == "kantor", text = "Kantor", onClick = { category = "kantor" })
                    CategoryChip(selected = category == "custom_interior", text = "Custom", onClick = { category = "custom_interior" })
                }
            }

            BumiyujiTextField(
                value = description,
                onValueChange = { description = it },
                label = "Deskripsi",
                singleLine = false,
                modifier = Modifier.heightIn(min = 120.dp)
            )

            Column {
                Text(text = "Gambar Utama", style = MaterialTheme.typography.titleSmall, fontWeight = FontWeight.Bold)
                Spacer(modifier = Modifier.height(12.dp))

                Box(
                    modifier = Modifier
                        .fillMaxWidth()
                        .height(200.dp)
                        .clip(RoundedCornerShape(16.dp))
                        .background(Color.White)
                        .border(1.dp, Color.Gray.copy(alpha = 0.3f), RoundedCornerShape(16.dp))
                        .clickable { launcher.launch("image/*") },
                    contentAlignment = Alignment.Center
                ) {
                    if (selectedImageUri != null) {
                        AsyncImage(
                            model = selectedImageUri,
                            contentDescription = null,
                            modifier = Modifier.fillMaxSize(),
                            contentScale = ContentScale.Crop
                        )
                    } else if (existingImageUrl != null) {
                        AsyncImage(
                            model = ImageUtils.resolveImageUrl(existingImageUrl),
                            contentDescription = null,
                            modifier = Modifier.fillMaxSize(),
                            contentScale = ContentScale.Crop
                        )
                    } else {
                        Column(horizontalAlignment = Alignment.CenterHorizontally) {
                            Icon(Icons.Default.CloudUpload, contentDescription = null, tint = GoldAccent, modifier = Modifier.size(48.dp))
                            Text(text = "Pilih Gambar Proyek", color = Color.Gray)
                        }
                    }

                    if (selectedImageUri != null || existingImageUrl != null) {
                        Surface(
                            modifier = Modifier.align(Alignment.BottomEnd).padding(12.dp),
                            shape = CircleShape,
                            color = Color.Black.copy(alpha = 0.5f)
                        ) {
                            Text(
                                text = "Ganti",
                                color = Color.White,
                                modifier = Modifier.padding(horizontal = 12.dp, vertical = 6.dp),
                                style = MaterialTheme.typography.labelSmall
                            )
                        }
                    }
                }
            }

            Spacer(modifier = Modifier.height(12.dp))

            BumiyujiButton(
                text = if (portfolioId == null) "Simpan Portfolio" else "Perbarui Portfolio",
                onClick = {
                    val imagePart = selectedImageUri?.let { uri ->
                        val file = FileUtils.uriToFile(uri, context)
                        val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                        MultipartBody.Part.createFormData("image", file.name, requestFile)
                    }

                    if (portfolioId == null) {
                        viewModel.createPortfolio(title, category, description, imagePart)
                    } else {
                        viewModel.updatePortfolio(portfolioId, title, category, description, imagePart)
                    }
                    onNavigateBack()
                },
                isLoading = viewModel.portfoliosUiState is UiState.Loading || viewModel.detailUiState is UiState.Loading
            )
        }
    }
}

@Composable
fun CategoryChip(selected: Boolean, text: String, onClick: () -> Unit) {
    Surface(
        modifier = Modifier.clickable { onClick() },
        shape = RoundedCornerShape(12.dp),
        color = if (selected) GoldAccent else Color.White,
        border = if (selected) null else BorderStroke(1.dp, Color.Gray.copy(alpha = 0.3f))
    ) {
        Text(
            text = text,
            modifier = Modifier.padding(horizontal = 16.dp, vertical = 8.dp),
            style = MaterialTheme.typography.labelLarge,
            color = if (selected) Color.White else Color.Gray,
            fontWeight = if (selected) FontWeight.Bold else FontWeight.Normal
        )
    }
}
