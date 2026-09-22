package com.example.bumiyuji.ui.screens

import android.net.Uri
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.animation.*
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.horizontalScroll
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Add
import androidx.compose.material.icons.filled.Close
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
import okhttp3.RequestBody.Companion.asRequestBody

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun PortfolioPhaseFormScreen(
    viewModel: PortfolioViewModel,
    portfolioId: Int,
    phaseId: Int,
    onNavigateBack: () -> Unit
) {
    val context = LocalContext.current

    var title by remember { mutableStateOf("") }
    var description by remember { mutableStateOf("") }
    var percentage by remember { mutableStateOf(0) }

    // Use remember for non-reactive lists or handle properly
    val existingImages = remember { mutableStateListOf<com.example.bumiyuji.data.api.PortfolioPhaseImageDto>() }
    val newImages = remember { mutableStateListOf<Uri>() }

    val launcher = rememberLauncherForActivityResult(
        contract = ActivityResultContracts.GetMultipleContents()
    ) { uris ->
        newImages.addAll(uris)
    }

    // MANDATORY: Fetch detail to populate form
    LaunchedEffect(portfolioId) {
        viewModel.fetchDetail(portfolioId)
    }

    val detailState = viewModel.detailUiState
    LaunchedEffect(detailState) {
        if (detailState is UiState.Success) {
            val phase = detailState.data.phases?.find { it.id == phaseId }
            if (phase != null) {
                title = phase.title
                description = phase.description ?: ""
                percentage = phase.percentage
                existingImages.clear()
                phase.images?.let { existingImages.addAll(it) }
            }
        }
    }

    val updateState = viewModel.phaseUpdateUiState
    LaunchedEffect(updateState) {
        if (updateState is UiState.Success) {
            onNavigateBack()
            viewModel.phaseUpdateUiState = UiState.Idle // Reset
        }
    }

    Scaffold(
        topBar = {
            BumiyujiTopBar(
                title = "Edit Tahap $percentage%",
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
            verticalArrangement = Arrangement.spacedBy(24.dp)
        ) {
            Text(
                text = "Informasi Tahapan",
                style = MaterialTheme.typography.titleMedium,
                fontWeight = FontWeight.Bold
            )

            BumiyujiTextField(
                value = title,
                onValueChange = { title = it },
                label = "Judul Tahapan"
            )

            BumiyujiTextField(
                value = description,
                onValueChange = { description = it },
                label = "Deskripsi",
                singleLine = false,
                modifier = Modifier.heightIn(min = 120.dp)
            )

            HorizontalDivider(color = Color.LightGray.copy(alpha = 0.5f))

            Text(
                text = "Galeri Foto",
                style = MaterialTheme.typography.titleMedium,
                fontWeight = FontWeight.Bold
            )

            // Horizontal Gallery Management
            Box(modifier = Modifier.fillMaxWidth().height(120.dp)) {
                Row(
                    modifier = Modifier.horizontalScroll(rememberScrollState()),
                    horizontalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    // Add Button
                    Surface(
                        modifier = Modifier
                            .size(100.dp)
                            .clip(RoundedCornerShape(16.dp))
                            .clickable { launcher.launch("image/*") },
                        color = Color.White,
                        border = androidx.compose.foundation.BorderStroke(1.dp, GoldAccent.copy(alpha = 0.3f))
                    ) {
                        Column(
                            horizontalAlignment = Alignment.CenterHorizontally,
                            verticalArrangement = Arrangement.Center
                        ) {
                            Icon(Icons.Default.Add, contentDescription = null, tint = GoldAccent)
                            Text("Tambah", style = MaterialTheme.typography.labelSmall, color = GoldAccent)
                        }
                    }

                    // New Images
                    newImages.forEach { uri ->
                        Box(modifier = Modifier.size(100.dp)) {
                            AsyncImage(
                                model = uri,
                                contentDescription = null,
                                modifier = Modifier.fillMaxSize().clip(RoundedCornerShape(16.dp)),
                                contentScale = ContentScale.Crop
                            )
                            IconButton(
                                onClick = { newImages.remove(uri) },
                                modifier = Modifier.align(Alignment.TopEnd).size(24.dp).background(Color.Black.copy(alpha = 0.5f), CircleShape)
                            ) {
                                Icon(Icons.Default.Close, contentDescription = null, tint = Color.White, modifier = Modifier.size(14.dp))
                            }
                            Surface(
                                modifier = Modifier.align(Alignment.BottomStart).padding(4.dp),
                                shape = RoundedCornerShape(4.dp),
                                color = GoldAccent
                            ) {
                                Text("BARU", modifier = Modifier.padding(horizontal = 4.dp), style = MaterialTheme.typography.labelSmall, color = Color.White)
                            }
                        }
                    }

                    // Existing Images
                    existingImages.forEach { img ->
                        Box(modifier = Modifier.size(100.dp)) {
                            AsyncImage(
                                model = ImageUtils.resolveImageUrl(img.image_url),
                                contentDescription = null,
                                modifier = Modifier.fillMaxSize().clip(RoundedCornerShape(16.dp)),
                                contentScale = ContentScale.Crop
                            )
                            IconButton(
                                onClick = {
                                    viewModel.deletePhaseImage(portfolioId, phaseId, img.id)
                                    existingImages.remove(img)
                                },
                                modifier = Modifier.align(Alignment.TopEnd).size(24.dp).background(Color.Black.copy(alpha = 0.5f), CircleShape)
                            ) {
                                Icon(Icons.Default.Close, contentDescription = null, tint = Color.White, modifier = Modifier.size(14.dp))
                            }
                        }
                    }
                }
            }

            if (updateState is UiState.Error) {
                Text(text = updateState.message, color = MaterialTheme.colorScheme.error)
            }

            Spacer(modifier = Modifier.height(16.dp))

            BumiyujiButton(
                text = "Simpan Perubahan",
                onClick = {
                    val parts = newImages.map { uri ->
                        val file = FileUtils.uriToFile(uri, context)
                        val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                        MultipartBody.Part.createFormData("images[]", file.name, requestFile)
                    }
                    viewModel.updatePhaseComplete(portfolioId, phaseId, title, description, parts)
                },
                isLoading = updateState is UiState.Loading
            )
        }
    }
}
