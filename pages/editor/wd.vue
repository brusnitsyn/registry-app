<script setup lang="ts">
import { useRouteQuery } from "@vueuse/router"
import { NInput } from 'naive-ui'
const zapId = useRouteQuery('zapId')
const tab = useRouteQuery('tab', 'pacient')

const {data: zapPacientData} = await useAPI(`/api/registry/zap/${zapId.value}/pacient`)
const {data: zapZsl} = await useAPI(`/api/registry/zap/${zapId.value}/zsl`)
const {data: zapSlZsl} = await useAPI(`/api/registry/zap/${zapId.value}/zsl/sl`)
const zapPacientForm = {}

const getIndexSl = (row) => {
  return zapSlZsl.value.map(m => m.id).indexOf(row.sl_registry_id)
}

const pacientTableColumns = [
  {
    key: 'id',
    title: 'ИД',
    width: 50,
  },
  {
    key: 'id_pac',
    title: 'ИД пациента',
    width: 320,
    render(row, index) {
      return h(NInput, {
        value: row.id_pac,
        placeholder: row.spolis,
        onUpdateValue(v) {
          zapPacient.value.id_pac = v
        }
      })
    }
  },
  {
    key: 'vpolis',
    title: 'vpolis',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.vpolis,
        placeholder: row.spolis,
        onUpdateValue(v) {
          zapPacient.value.vpolis = v
        }
      })
    }
  },
  {
    key: 'spolis',
    title: 'spolis',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.spolis,
        placeholder: row.spolis,
        onUpdateValue(v) {
          zapPacient.value.spolis = v
        }
      })
    }
  },
  {
    key: 'npolis',
    title: 'npolis',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.npolis,
        placeholder: row.npolis,
        onUpdateValue(v) {
          zapPacient.value.npolis = v
        }
      })
    }
  },
  {
    key: 'enp',
    title: 'enp',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.enp,
        placeholder: row.enp,
        onUpdateValue(v) {
          zapPacient.value.enp = v
        }
      })
    }
  },
  {
    key: 'st_okato',
    title: 'st_okato',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.st_okato,
        placeholder: row.st_okato,
        onUpdateValue(v) {
          zapPacient.value.st_okato = v
        }
      })
    }
  },
  {
    key: 'smo',
    title: 'smo',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.smo,
        placeholder: row.smo,
        onUpdateValue(v) {
          zapPacient.value.smo = v
        }
      })
    }
  },
  {
    key: 'inv',
    title: 'inv',
    width: 60,
    render(row, index) {
      return h(NInput, {
        value: row.inv,
        placeholder: row.inv,
        onUpdateValue(v) {
          zapPacient.value.inv = v
        }
      })
    }
  },
  {
    key: 'mse',
    title: 'mse',
    width: 200,
    render(row, index) {
      return h(NInput, {
        value: row.mse,
        placeholder: row.mse,
        onUpdateValue(v) {
          zapPacient.value.mse = v
        }
      })
    }
  },
  {
    key: 'novor',
    title: 'novor',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.novor,
        placeholder: row.novor,
        onUpdateValue(v) {
          zapPacient.value.novor = v
        }
      })
    }
  },
  {
    key: 'vnov_d',
    title: 'vnov_d',
    width: 200,
    render(row, index) {
      return h(NInput, {
        value: row.vnov_d,
        placeholder: row.vnov_d,
        onUpdateValue(v) {
          zapPacient.value.vnov_d = v
        }
      })
    }
  },
]
const pacientPersTableColumns = [
  {
    key: 'id',
    title: 'ИД',
    width: 50,
  },
  {
    key: 'fam',
    title: 'Фамилия',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.fam,
        placeholder: row.fam,
        onUpdateValue(v) {
          zapPacient.value.fam = v
        }
      })
    }
  },
  {
    key: 'im',
    title: 'Имя',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.im,
        placeholder: row.im,
        onUpdateValue(v) {
          zapPacient.value.im = v
        }
      })
    }
  },
  {
    key: 'ot',
    title: 'Отчество',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.ot,
        placeholder: row.ot,
        onUpdateValue(v) {
          zapPacient.value.ot = v
        }
      })
    }
  },
  {
    key: 'w',
    title: 'Пол',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.w,
        placeholder: row.w,
        onUpdateValue(v) {
          zapPacient.value.w = v
        }
      })
    }
  },
  {
    key: 'dr',
    title: 'Дата рождения',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.dr,
        placeholder: row.dr,
        onUpdateValue(v) {
          zapPacient.value.dr = v
        }
      })
    }
  },
  {
    key: 'snils',
    title: 'СНИЛС',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.snils,
        placeholder: row.snils,
        onUpdateValue(v) {
          zapPacient.value.snils = v
        }
      })
    }
  },
  {
    key: 'okatog',
    title: 'OKATOG',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.okatog,
        placeholder: row.okatog,
        onUpdateValue(v) {
          zapPacient.value.okatog = v
        }
      })
    }
  },
  {
    key: 'OKATOP',
    title: 'OKATOP',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.okatop,
        placeholder: row.okatop,
        onUpdateValue(v) {
          zapPacient.value.okatop = v
        }
      })
    }
  },
]
const zslTableColumns = [
  {
    key: 'id',
    title: 'ИД',
    width: 50
  },
  {
    key: 'idcase',
    title: 'idcase',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.idcase,
        placeholder: row.idcase,
        onUpdateValue(v) {
          zapZsl.value.idcase = v
        }
      })
    }
  },
  {
    key: 'usl_ok',
    title: 'usl_ok',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.usl_ok,
        placeholder: row.usl_ok,
        onUpdateValue(v) {
          zapZsl.value.usl_ok = v
        }
      })
    }
  },
  {
    key: 'vidpom',
    title: 'vidpom',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.vidpom,
        placeholder: row.vidpom,
        onUpdateValue(v) {
          zapZsl.value.vidpom = v
        }
      })
    }
  },
  {
    key: 'for_pom',
    title: 'for_pom',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.for_pom,
        placeholder: row.for_pom,
        onUpdateValue(v) {
          zapZsl.value.for_pom = v
        }
      })
    }
  },
  {
    key: 'npr_mo',
    title: 'npr_mo',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.npr_mo,
        placeholder: row.npr_mo,
        onUpdateValue(v) {
          zapZsl.value.npr_mo = v
        }
      })
    }
  },
  {
    key: 'nrp_date',
    title: 'nrp_date',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.npr_date,
        placeholder: row.npr_date,
        onUpdateValue(v) {
          zapZsl.value.npr_date = v
        }
      })
    }
  },
  {
    key: 'lpu',
    title: 'lpu',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.lpu,
        placeholder: row.lpu,
        onUpdateValue(v) {
          zapZsl.value.lpu = v
        }
      })
    }
  },
  {
    key: 'vbr',
    title: 'vbr',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.vbr,
        placeholder: row.vbr,
        onUpdateValue(v) {
          zapZsl.value.vbr = v
        }
      })
    }
  },
  {
    key: 'date_z_1',
    title: 'date_z_1',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.date_z_1,
        placeholder: row.date_z_1,
        onUpdateValue(v) {
          zapZsl.value.date_z_1 = v
        }
      })
    }
  },
  {
    key: 'date_z_2',
    title: 'date_z_2',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.date_z_2,
        placeholder: row.date_z_2,
        onUpdateValue(v) {
          zapZsl.value.date_z_2 = v
        }
      })
    }
  },
  {
    key: 'p_otk',
    title: 'p_otk',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.p_otk,
        placeholder: row.p_otk,
        onUpdateValue(v) {
          zapZsl.value.p_otk = v
        }
      })
    }
  },
  {
    key: 'rslt_d',
    title: 'rslt_d',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.rslt_d,
        placeholder: row.rslt_d,
        onUpdateValue(v) {
          zapZsl.value.rslt_d = v
        }
      })
    }
  },
  {
    key: 'kd_z',
    title: 'kd_z',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.kd_z,
        placeholder: row.kd_z,
        onUpdateValue(v) {
          zapZsl.value.kd_z = v
        }
      })
    }
  },
  {
    key: 'vnov_m',
    title: 'vnov_m',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.vnov_m,
        placeholder: row.vnov_m,
        onUpdateValue(v) {
          zapZsl.value.vnov_m = v
        }
      })
    }
  },
  {
    key: 'rslt',
    title: 'rslt',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.rslt,
        placeholder: row.rslt,
        onUpdateValue(v) {
          zapZsl.value.rslt = v
        }
      })
    }
  },
  {
    key: 'ishod',
    title: 'ishod',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.ishod,
        placeholder: row.ishod,
        onUpdateValue(v) {
          zapZsl.value.ishod = v
        }
      })
    }
  },
  {
    key: 'os_sluch',
    title: 'os_sluch',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.os_sluch,
        placeholder: row.os_sluch,
        onUpdateValue(v) {
          zapZsl.value.os_sluch = v
        }
      })
    }
  },
  {
    key: 'vb_p',
    title: 'vb_p',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.vb_p,
        placeholder: row.vb_p,
        onUpdateValue(v) {
          zapZsl.value.vb_p = v
        }
      })
    }
  },
  {
    key: 'idsp',
    title: 'idsp',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.idsp,
        placeholder: row.idsp,
        onUpdateValue(v) {
          zapZsl.value.idsp = v
        }
      })
    }
  },
  {
    key: 'sumv',
    title: 'sumv',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.sumv,
        placeholder: row.sumv,
        onUpdateValue(v) {
          zapZsl.value.sumv = v
        }
      })
    }
  },
]
const slZslTableColumns = [
  {
    key: 'id',
    title: 'ИД',
    width: 80,
  },
  {
    key: 'sl_id',
    title: 'sl_id',
    width: 320,
    render(row, index) {
      return h(NInput, {
        value: row.sl_id,
        placeholder: row.sl_id,
        onUpdateValue(v) {
          console.log(zapSlZsl)
          zapSlZsl.value[index].sl_id = v
        }
      })
    }
  },
  {
    key: 'lpu_1',
    title: 'lpu_1',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.lpu_1,
        placeholder: row.lpu_1,
        onUpdateValue(v) {
          zapSlZsl.value[index].lpu_1 = v
        }
      })
    }
  },
  {
    key: 'podr',
    title: 'podr',
    width: 140,
    render(row, index) {
      return h(NInput, {
        value: row.podr,
        placeholder: row.podr,
        onUpdateValue(v) {
          zapSlZsl.value[index].podr = v
        }
      })
    }
  },
  {
    key: 'profil',
    title: 'profil',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.profil,
        placeholder: row.profil,
        onUpdateValue(v) {
          zapSlZsl.value[index].profil = v
        }
      })
    }
  },
  {
    key: 'profil_k',
    title: 'profil_k',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.profil_k,
        placeholder: row.profil_k,
        onUpdateValue(v) {
          zapSlZsl.value[index].profil_k = v
        }
      })
    }
  },
  {
    key: 'det',
    title: 'det',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.det,
        placeholder: row.det,
        onUpdateValue(v) {
          zapSlZsl.value[index].det = v
        }
      })
    }
  },
  {
    key: 'nhistory',
    title: 'nhistory',
    width: 120,
    render(row, index) {
      return h(NInput, {
        value: row.nhistory,
        placeholder: row.nhistory,
        onUpdateValue(v) {
          zapSlZsl.value[index].nhistory = v
        }
      })
    }
  },
  {
    key: 'p_per',
    title: 'p_per',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.p_per,
        placeholder: row.p_per,
        onUpdateValue(v) {
          zapSlZsl.value[index].p_per = v
        }
      })
    }
  },
  {
    key: 'date_1',
    title: 'date_1',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.date_1,
        placeholder: row.date_1,
        onUpdateValue(v) {
          zapSlZsl.value[index].date_1 = v
        }
      })
    }
  },
  {
    key: 'date_2',
    title: 'date_2',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.date_2,
        placeholder: row.date_2,
        onUpdateValue(v) {
          zapSlZsl.value[index].date_2 = v
        }
      })
    }
  },
  {
    key: 'kd',
    title: 'kd',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.kd,
        placeholder: row.kd,
        onUpdateValue(v) {
          zapSlZsl.value[index].kd = v
        }
      })
    }
  },
  {
    key: 'ds0',
    title: 'ds0',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.ds0,
        placeholder: row.ds0,
        onUpdateValue(v) {
          zapSlZsl.value[index].ds0 = v
        }
      })
    }
  },
  {
    key: 'ds1',
    title: 'ds1',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.ds1,
        placeholder: row.ds1,
        onUpdateValue(v) {
          zapSlZsl.value[index].ds1 = v
        }
      })
    }
  },
  {
    key: 'ds2',
    title: 'ds2',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.ds2,
        placeholder: row.ds2,
        onUpdateValue(v) {
          zapSlZsl.value[index].ds2 = v
        }
      })
    }
  },
  {
    key: 'c_zab',
    title: 'c_zab',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.c_zab,
        placeholder: row.c_zab,
        onUpdateValue(v) {
          zapSlZsl.value[index].c_zab = v
        }
      })
    }
  },
  {
    key: 'ds_onk',
    title: 'ds_onk',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.ds_onk,
        placeholder: row.ds_onk,
        onUpdateValue(v) {
          zapSlZsl.value[index].ds_onk = v
        }
      })
    }
  },
  {
    key: 'prvs',
    title: 'prvs',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.prvs,
        placeholder: row.prvs,
        onUpdateValue(v) {
          zapSlZsl.value[index].prvs = v
        }
      })
    }
  },
  {
    key: 'vers_spec',
    title: 'vers_spec',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.vers_spec,
        placeholder: row.vers_spec,
        onUpdateValue(v) {
          zapSlZsl.value[index].vers_spec = v
        }
      })
    }
  },
  {
    key: 'iddokt',
    title: 'iddokt',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.iddokt,
        placeholder: row.iddokt,
        onUpdateValue(v) {
          zapSlZsl.value[index].iddokt = v
        }
      })
    }
  },
  {
    key: 'ed_col',
    title: 'ed_col',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.ed_col,
        placeholder: row.ed_col,
        onUpdateValue(v) {
          zapSlZsl.value[index].ed_col = v
        }
      })
    }
  },
  {
    key: 'tarif',
    title: 'tarif',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.tarif,
        placeholder: row.tarif,
        onUpdateValue(v) {
          zapSlZsl.value[index].tarif = v
        }
      })
    }
  },
  {
    key: 'sum_m',
    title: 'sum_m',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.sum_m,
        placeholder: row.sum_m,
        onUpdateValue(v) {
          zapSlZsl.value[index].sum_m = v
        }
      })
    }
  },
]
const uslSlTableColumns = [
  {
    key: 'id',
    title: 'ИД',
    width: 80,
  },
  {
    key: 'idserv',
    title: 'idserv',
    width: 320,
    render(row, index) {
      return h(NInput, {
        value: row.idserv,
        status: row.errors.map(err => err.im_pol).indexOf('IDSERV') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].idserv = v
        }
      })
    }
  },
  {
    key: 'lpu',
    title: 'lpu',
    width: 120,
    render(row, index) {
      return h(NInput, {
        value: row.lpu,
        status: row.errors.map(err => err.im_pol).indexOf('LPU') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].lpu = v
        }
      })
    }
  },
  {
    key: 'lpu_1',
    title: 'lpu_1',
    width: 120,
    render(row, index) {
      return h(NInput, {
        value: row.lpu_1,
        status: row.errors.map(err => err.im_pol).indexOf('LPU_1') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].lpu_1 = v
        }
      })
    }
  },
  {
    key: 'podr',
    title: 'podr',
    width: 130,
    render(row, index) {
      return h(NInput, {
        value: row.podr,
        status: row.errors.map(err => err.im_pol).indexOf('PODR') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].podr = v
        }
      })
    }
  },
  {
    key: 'profil',
    title: 'profil',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.profil,
        status: row.errors.map(err => err.im_pol).indexOf('PROFIL') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].profil = v
        }
      })
    }
  },
  {
    key: 'vid_vme',
    title: 'vid_vme',
    width: 140,
    render(row, index) {
      return h(NInput, {
        value: row.vid_vme,
        status: row.errors.map(err => err.im_pol).indexOf('VID_VME') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].vid_vme = v
        }
      })
    }
  },
  {
    key: 'det',
    title: 'det',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.det,
        status: row.errors.map(err => err.im_pol).indexOf('DET') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].det = v
        }
      })
    }
  },
  {
    key: 'date_in',
    title: 'date_in',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.date_in,
        status: row.errors.map(err => err.im_pol).indexOf('DATE_IN') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].date_in = v
        }
      })
    }
  },
  {
    key: 'date_out',
    title: 'date_out',
    width: 180,
    render(row, index) {
      return h(NInput, {
        value: row.date_out,
        status: row.errors.map(err => err.im_pol).indexOf('DATE_OUT') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].date_out = v
        }
      })
    }
  },
  {
    key: 'ds',
    title: 'ds',
    width: 100,
    render(row, index) {
      return h(NInput, {
        value: row.ds,
        status: row.errors.map(err => err.im_pol).indexOf('DS') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].errors = []
          zapSlZsl.value[indexRow].usl[index].ds = v
        },
      })
    }
  },
  {
    key: 'code_usl',
    title: 'code_usl',
    width: 140,
    render(row, index) {
      return h(NInput, {
        value: row.code_usl,
        status: row.errors.map(err => err.im_pol).indexOf('CODE_USL') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].code_usl = v
        }
      })
    }
  },
  {
    key: 'kol_usl',
    title: 'kol_usl',
    width: 80,
    render(row, index) {
      return h(NInput, {
        value: row.kol_usl,
        status: row.errors.map(err => err.im_pol).indexOf('KOL_USL') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].kol_usl = v
        }
      })
    }
  },
  {
    key: 'tarif',
    title: 'tarif',
    width: 120,
    render(row, index) {
      return h(NInput, {
        value: row.tarif,
        status: row.errors.map(err => err.im_pol).indexOf('TARIF') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].tarif = v
        }
      })
    }
  },
  {
    key: 'sumv_usl',
    title: 'sumv_usl',
    width: 120,
    render(row, index) {
      return h(NInput, {
        value: row.sumv_usl,
        status: row.errors.map(err => err.im_pol).indexOf('SUMV_USL') >= 0 ? 'error': '',
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].usl[index].sumv_usl = v
        }
      })
    }
  },
]
const onkSlTableColumn = [
  {
    key: 'id',
    title: 'ИД',
    width: 50,
  },
  {
    key: 'ds1_t',
    title: 'ds1_t',
    width: 50,
    render(row, index) {
      return h(NInput, {
        value: row.ds1_t,
        placeholder: row.ds1_t,
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].onk_sl.ds1_t = v
        }
      })
    }
  },
  {
    key: 'stad',
    title: 'stad',
    width: 50,
    render(row, index) {
      return h(NInput, {
        value: row.stad,
        placeholder: row.stad,
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].onk_sl.stad = v
        }
      })
    }
  },
  {
    key: 'onk_t',
    title: 'onk_t',
    width: 50,
    render(row, index) {
      return h(NInput, {
        value: row.onk_t,
        placeholder: row.onk_t,
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].onk_sl.onk_t = v
        }
      })
    }
  },
  {
    key: 'onk_n',
    title: 'onk_n',
    width: 50,
    render(row, index) {
      return h(NInput, {
        value: row.onk_n,
        placeholder: row.onk_n,
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].onk_sl.onk_n = v
        }
      })
    }
  },
  {
    key: 'onk_m',
    title: 'onk_m',
    width: 50,
    render(row, index) {
      return h(NInput, {
        value: row.onk_m,
        placeholder: row.onk_m,
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].onk_sl.onk_m = v
        }
      })
    }
  },
  {
    key: 'wei',
    title: 'wei',
    width: 50,
    render(row, index) {
      return h(NInput, {
        value: row.wei,
        placeholder: row.wei,
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].onk_sl.wei = v
        }
      })
    }
  },
  {
    key: 'hei',
    title: 'hei',
    width: 50,
    render(row, index) {
      return h(NInput, {
        value: row.hei,
        placeholder: row.hei,
        onUpdateValue(v) {
          const indexRow = getIndexSl(row)
          zapSlZsl.value[indexRow].onk_sl.hei = v
        }
      })
    }
  },
]
</script>

<template>
  <PageBody>
    <NTabs :value="tab" @update:value="value => tab = value" type="segment" animated>
      <NTabPane name="pacient" tab="Пациент" display-directive="if">
        <NSpace vertical>
          <NDataTable :columns="pacientTableColumns" :data="[zapPacientData]" />
          <NDataTable :columns="pacientPersTableColumns" :data="[zapPacientData.pers]" />
        </NSpace>
      </NTabPane>
      <NTabPane name="zsl" tab="Законченный случай" display-directive="if">
        <NSpace vertical>
          <NDataTable :columns="zslTableColumns" :data="[zapZsl]" />
        </NSpace>
      </NTabPane>
      <NTabPane name="sl" tab="Случаи" display-directive="if">
        <NSpace vertical>
          <NDataTable :columns="slZslTableColumns" :data="zapSlZsl" />

          <NCollapse class="pt-4">
            <NCollapseItem v-for="(sl, index) in zapSlZsl" :title="`Случай ${sl.sl_id}`">
              <NSpace vertical>
                <div class="space-y-2">
                  <span class="font-semibold">Услуги</span>
                  <NDataTable :columns="uslSlTableColumns" :data="sl.usl" />
                </div>
                <div v-if="sl.onk_sl" class="space-y-2">
                  <span class="font-semibold">onk_sl</span>
                  <NDataTable :columns="onkSlTableColumn" :data="[sl.onk_sl]" />
                </div>
              </NSpace>
            </NCollapseItem>
          </NCollapse>
        </NSpace>
      </NTabPane>
    </NTabs>
  </PageBody>
</template>

<style scoped>

</style>